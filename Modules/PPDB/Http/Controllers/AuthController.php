<?php

namespace Modules\PPDB\Http\Controllers;

use App\Models\dataMurid;
use App\Models\User;
use ErrorException;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PPDB\Http\Requests\RegisterRequest;
use Modules\PPDB\Entities\PpdbSetting;
use Session;
use DB;

class AuthController extends Controller
{
    use RegistersUsers;
    
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }
    
    // Register View
    public function registerView()
    {
        // Check if PPDB registration is open
        if (!PpdbSetting::isOpen()) {
            return view('ppdb::auth.closed', [
                'message' => PpdbSetting::getClosedMessage()
            ]);
        }
        
        return view('ppdb::auth.register');
    }
    
    // Register Store
    public function registerStore(RegisterRequest $request)
    {
        // Check if PPDB registration is open
        if (!PpdbSetting::isOpen()) {
            Session::flash('error', PpdbSetting::getClosedMessage());
            return redirect()->back();
        }
        
        try {
            DB::beginTransaction();

           // Pilih kalimat
           $kalimatKe  = "1";
           $username   = implode(" ", array_slice(explode(" ", $request->name), 0, $kalimatKe)); // ambil kalimat
           
            $register = new User();
            $register->name      = $request->name;
            $register->username  = $username;
            $register->email     = $request->email;
            $register->role      = 'Guest';
            $register->password  = bcrypt($request->password);
            $register->save();

            if ($register) {
                $murid = new dataMurid();
                $murid->user_id         =   $register->id;
                $murid->whatsapp        =   $request->whatsapp;
                $murid->jenis_kelamin    =   $request->jenis_kelamin;
                $murid->save();
            }

            $register->assignRole($register->role);
            
            DB::commit();
            Session::flash('success','Success, Data Berhasil dikirim !');
            return redirect()->route('login');
        } catch (ErrorException $e) {
            DB::rollback();
            throw new ErrorException($e->getMessage());
        }
    }
}
