<?php

namespace Modules\SPP\Http\Controllers;

use App\Helpers\GlobalHelpers;
use App\Models\User;
use Carbon\Carbon;
use ErrorException;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\SPP\Entities\DetailPaymentSpp;
use Modules\SPP\Entities\PaymentSpp;
use Modules\SPP\Entities\SppSetting;
use Midtrans\Config; // Import Midtrans Config
use Midtrans\Snap; // Import Midtrans Snap
use Midtrans\Notification; // Import Midtrans Notification

class SPPController extends Controller
{
    use GlobalHelpers;

    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config("midtrans.server_key");
        Config::$isProduction = config("midtrans.is_production");
        Config::$isSanitized = config("midtrans.is_sanitized");
        Config::$is3ds = config("midtrans.is_3ds");
    }

    public function index()
    {
        return view("spp::index");
    }

    // Murid
    public function murid()
    {
        $payment = User::with("payment")
            ->whereHas("payment", function ($a) {
                $a->where("year", date("Y"));
            })
            ->where("role", "Murid")
            ->get();
        return view("spp::murid.index", compact("payment"));
    }

    // Detail Pembayaran
    public function detail($id)
    {
        $payment = PaymentSpp::with(["detailPayment.aprroveBy", "user.muridDetail"])->findOrFail($id);
        // Pass client key to the view
        $clientKey = config("midtrans.client_key");
        return view("spp::murid.show", compact("payment", "clientKey"));
    }

    // Generate Midtrans Snap Token
    public function generateMidtransToken(Request $request)
    {
        $request->validate([
            "detail_payment_id" => "required|exists:detail_payment_spps,id",
        ]);

        $detailPayment = DetailPaymentSpp::with("paymentSpp.user.muridDetail")->find($request->detail_payment_id);

        if (!$detailPayment || $detailPayment->status == "paid") {
            return response()->json(["error" => "Pembayaran tidak valid atau sudah lunas."], 400);
        }

        // Generate a unique order ID (e.g., SPP-<detail_payment_id>-<timestamp>)
        $orderId = "SPP-" . $detailPayment->id . "-" . time();
        // Store order ID in the detail payment record for later reference
        $detailPayment->midtrans_order_id = $orderId;
        $detailPayment->save();

        $params = [
            "transaction_details" => [
                "order_id" => $orderId,
                "gross_amount" => $detailPayment->amount, // Use amount from detail payment
            ],
            "customer_details" => [
                "first_name" => $detailPayment->paymentSpp->user->name,
                "email" => $detailPayment->paymentSpp->user->email,
                "phone" => $detailPayment->paymentSpp->user->muridDetail->phone ?? "-", // Optional phone
            ],
            "item_details" => [
                [
                    "id" => $detailPayment->id,
                    "price" => $detailPayment->amount,
                    "quantity" => 1,
                    "name" => "SPP Bulan " . $detailPayment->month . " " . $detailPayment->paymentSpp->year,
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(["snap_token" => $snapToken]);
        } catch (Exception $e) {
            Log::error("Midtrans Snap Token Error: " . $e->getMessage());
            return response()->json(["error" => "Gagal membuat token pembayaran: " . $e->getMessage()], 500);
        }
    }

    // Handle Midtrans Notification
    public function handleMidtransNotification(Request $request)
    {
        try {
            $notification = new Notification();

            DB::beginTransaction();

            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status;
            $transactionId = $notification->transaction_id;

            Log::info("Midtrans Notification Received", [
                "order_id" => $orderId,
                "transaction_status" => $transactionStatus,
                "payment_type" => $paymentType,
                "fraud_status" => $fraudStatus,
                "transaction_id" => $transactionId,
            ]);

            // Find the payment detail by Midtrans order ID
            $detailPayment = DetailPaymentSpp::where("midtrans_order_id", $orderId)->first();

            if (!$detailPayment) {
                Log::warning("Midtrans Notification: Detail Payment not found for order_id: " . $orderId);
                DB::rollback(); // Rollback if payment not found
                return response("Payment detail not found", 404);
            }

            // Check if the payment status is already processed to prevent double processing
            if (in_array($detailPayment->status, ["paid", "failed", "expired", "cancelled"])) {
                 Log::info("Midtrans Notification: Payment already processed for order_id: " . $orderId . " with status: " . $detailPayment->status);
                 DB::commit(); // Commit even if already processed to acknowledge notification
                 return response("Payment already processed", 200);
            }

            $statusToUpdate = "unpaid"; // Default status

            if ($transactionStatus == "capture") {
                // For credit card
                if ($fraudStatus == "challenge") {
                    // TODO: Set transaction status on your database to 'challenge' e.g.
                    $statusToUpdate = "pending"; // Or a specific 'challenge' status if you have one
                } elseif ($fraudStatus == "accept") {
                    // TODO: Set transaction status on your database to 'success' e.g.
                    $statusToUpdate = "paid";
                }
            } elseif ($transactionStatus == "settlement") {
                // TODO: set transaction status on your database to 'success' e.g.
                $statusToUpdate = "paid";
            } elseif ($transactionStatus == "pending") {
                // TODO: set transaction status on your database to 'pending' e.g.
                $statusToUpdate = "pending";
            } elseif (in_array($transactionStatus, ["deny", "cancel", "expire"])) {
                // TODO: set transaction status on your database to 'failure' e.g.
                $statusToUpdate = "failed"; // Or 'expired', 'cancelled' based on $transactionStatus
                 if ($transactionStatus == "expire") $statusToUpdate = "expired";
                 if ($transactionStatus == "cancel") $statusToUpdate = "cancelled";
                 if ($transactionStatus == "deny") $statusToUpdate = "failed";
            }

            // Update DetailPaymentSpp status
            $detailPayment->status = $statusToUpdate;
            $detailPayment->midtrans_transaction_id = $transactionId;
            $detailPayment->midtrans_payment_type = $paymentType;

            // If paid, set approval details (can be system/automated user)
            if ($statusToUpdate == "paid") {
                $detailPayment->approve_by = null; // Or a system user ID if you have one
                $detailPayment->approve_date = Carbon::now();
            }
            $detailPayment->update();

            // If paid, update the main PaymentSpp record
            if ($statusToUpdate == "paid") {
                $pay = PaymentSpp::find($detailPayment->payment_id);
                if ($pay) {
                    $monthField = $detailPayment->month;
                    if (property_exists($pay, $monthField)) {
                        $pay->{$monthField} = "paid";
                        $pay->update();
                    } else {
                         Log::warning("Midtrans Notification: Invalid month field '{$monthField}' for PaymentSpp ID: {$pay->id}");
                    }
                } else {
                     Log::warning("Midtrans Notification: PaymentSpp not found for ID: {$detailPayment->payment_id}");
                }
            }

            DB::commit();
            Log::info("Midtrans Notification Processed Successfully for order_id: " . $orderId);
            return response("Notification processed successfully", 200);
        } catch (Exception $e) {
            DB::rollback();
            Log::error("Midtrans Notification Error: " . $e->getMessage() . " for Order ID: " . ($orderId ?? "N/A"));
            // Return 500 but log the error. Midtrans might retry.
            return response("Internal Server Error", 500);
        }
    }

    // --- Existing Methods --- (Keep updatePembayaran for now, maybe remove later)

    // Update Pembayaran (Manual - Consider removing or modifying after Midtrans is stable)
    public function updatePembayaran(Request $request)
    {
        // ... (existing manual update code) ...
        // Consider adding a check here to prevent manual update if Midtrans payment exists
        try {
            DB::beginTransaction();

            $payment = DetailPaymentSpp::find($request->id_payment);

            // Add check: Prevent manual update if already paid via Midtrans or pending
            if ($payment->status === 'paid' || $payment->status === 'pending') {
                 Session::flash('error', 'Pembayaran ini sedang diproses atau sudah lunas melalui sistem otomatis.');
                 return response()->json(['error' => 'Pembayaran ini sedang diproses atau sudah lunas melalui sistem otomatis.'], 400);
            }

            $payment->status        = 'paid';
            $payment->approve_by    = Auth::id();
            $payment->approve_date  = Carbon::now();
            $payment->update();

            // Update Payment
            $pay = PaymentSpp::find($payment->payment_id);
            if ($pay) {
                $monthField = $payment->month;
                 if (property_exists($pay, $monthField)) {
                     $pay->{$monthField} = 'paid';
                     $pay->update();
                 } else {
                     Log::warning("Manual Update: Invalid month field '{$monthField}' for PaymentSpp ID: {$pay->id}");
                 }
            } else {
                 Log::warning("Manual Update: PaymentSpp not found for ID: {$payment->payment_id}");
            }

            DB::commit();
            Session::flash('success', 'Pembayaran Berhasil Dikonfirmasi Secara Manual.');
            // Return something compatible with the original AJAX call if needed
            // return $payment; // Original return might be needed by frontend JS
            return response()->json(['success' => 'Pembayaran Berhasil Dikonfirmasi Secara Manual.']);
        } catch (\ErrorException $e) {
            DB::rollback();
            Log::error("Manual Payment Update Error: " . $e->getMessage());
            // throw new ErrorException($e->getMessage()); // Original throw
            Session::flash('error', 'Gagal mengkonfirmasi pembayaran: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengkonfirmasi pembayaran: ' . $e->getMessage()], 500);
        }
    }

    public function setting()
    {
        return view("spp::setting");
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "amount" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction(); // Added transaction
            $spp_setting = SppSetting::first(); // Use first() directly

            if (!$spp_setting) { // Check if null
                SppSetting::create([
                    "amount" => $request->amount,
                    "update_by" => auth()->user()->id,
                ]);
            } else {
                $spp_setting->update([
                    "amount" => $request->amount,
                    "update_by" => auth()->user()->id,
                ]);
            }

            DB::commit();
            Session::flash("success", "Biaya SPP berhasil diupdate.");
            return back();
        } catch (Exception $error) {
            DB::rollback();
            Log::error("SPP Setting Update Error: " . $error->getMessage()); // Log error
            Session::flash("error", "Gagal mengupdate biaya SPP: " . $error->getMessage());
            return back();
        }
    }
}

