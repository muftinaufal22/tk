<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyDetailPaymentSppsForMidtrans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add new columns
        Schema::table("detail_payment_spps", function (Blueprint $table) {
            $table->string("midtrans_order_id")->nullable()->after("approve_date");
            $table->string("midtrans_transaction_id")->nullable()->after("midtrans_order_id");
            $table->string("midtrans_payment_type")->nullable()->after("midtrans_transaction_id");
        });

        // Add unique constraint for midtrans_order_id
        Schema::table("detail_payment_spps", function (Blueprint $table) {
            $table->unique("midtrans_order_id");
        });

        // Modify status enum using raw SQL (MySQL specific)
        DB::statement("ALTER TABLE detail_payment_spps MODIFY COLUMN status ENUM('paid', 'unpaid', 'pending', 'failed', 'expired', 'cancelled', 'challenge') NOT NULL DEFAULT 'unpaid'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("detail_payment_spps", function (Blueprint $table) {
            // Drop unique constraint first
            $table->dropUnique(['midtrans_order_id']);
            
            // Drop columns
            $table->dropColumn(['midtrans_order_id', 'midtrans_transaction_id', 'midtrans_payment_type']);
        });

        // Revert status enum
        DB::statement("ALTER TABLE detail_payment_spps MODIFY COLUMN status ENUM('paid', 'unpaid') NOT NULL DEFAULT 'unpaid'");
    }
}