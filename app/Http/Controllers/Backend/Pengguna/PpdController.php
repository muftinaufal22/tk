<?php

namespace App\Http\Controllers\Backend\Pengguna;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\PPDB\Entities\PpdbSetting;
use Session;
use DB;

class PpdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = PpdbSetting::first();
        if (!$setting) {
            $setting = new PpdbSetting();
            $setting->is_active = true;
            $setting->save();
        }
        
        return view('backend.pengguna.ppd.index', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $setting = PpdbSetting::first();
            if (!$setting) {
                $setting = new PpdbSetting();
            }
            
            $setting->tanggal_buka = $request->tanggal_buka;
            $setting->tanggal_tutup = $request->tanggal_tutup;
            $setting->is_active = $request->has('is_active');
            $setting->pesan_nonaktif = $request->pesan_nonaktif;
            $setting->save();
            
            DB::commit();
            Session::flash('success', 'Pengaturan PPDB berhasil disimpan!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
