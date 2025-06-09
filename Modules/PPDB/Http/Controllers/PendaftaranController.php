<?php

namespace Modules\PPDB\Http\Controllers;

use App\Models\dataMurid;
use App\Models\User;
use ErrorException;
use Illuminate\Http\Request;
use Modules\PPDB\Http\Requests\{BerkasMuridRequest, DataMuridRequest,DataOrtuRequest};
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\PPDB\Entities\BerkasMurid;
use Modules\PPDB\Entities\DataOrangTua;
use Illuminate\Support\Facades\Session;

class PendaftaranController extends Controller
{

    // Data Murid
    public function index()
    {
        $user = User::with('muridDetail','dataOrtu')->where('status','Aktif')->where('id',Auth::id())->first();

        // Jika data murid sudah lengkap
        if ($user->muridDetail->agama) {
           return redirect('ppdb/form-data-orangtua');
        }
        return view('ppdb::backend.pendaftaran.index', compact('user'));
    }

    // Update Data Murid
    public function update(DataMuridRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = User::with('muridDetail')->where('id',$id)->first();
            $user->name     = $request->name;
            $user->email     = $request->email;
            $user->update();

            if ($user) {
                $murid = dataMurid::where('user_id',$id)->first();
                $murid->tempat_lahir    = $request->tempat_lahir;
                $murid->tgl_lahir       = $request->tgl_lahir;
                $murid->agama           = $request->agama;
                $murid->telp            = $request->telp;
                $murid->whatsapp        = $request->whatsapp;
                $murid->alamat          = $request->alamat;
                $murid->jenis_kelamin    = $request->jenis_kelamin;
                $murid->update();

                if ($murid) {
                    $ortu = new DataOrangTua;
                    $ortu->user_id  = $id;
                    $ortu->save();
                }
            }
            DB::commit();
            Session::flash('success','Success, Data Berhasil dikirim !');
            return redirect('ppdb/form-data-orangtua');
        } catch (ErrorException $e) {
            DB::rollback();
            throw new ErrorException($e->getMessage());
        }
    }

    // Data Orang Tua
    public function dataOrtuView()
    {
        $ortu = DataOrangTua::where('user_id', Auth::id())->first();

        // Jika data orang tua masih empty
        if (!$ortu) {
            Session::flash('error','Data kamu belum lengkap !');
            return redirect('ppdb/form-pendaftaran');
        }

        // jika data orang tua sudah terisi
        if ($ortu->telp_ayah) {
            Session::flash('success','Data kamu sudah lengkap !');
            return redirect('ppdb/form-berkas');
        }
        return view('ppdb::backend.pendaftaran.dataOrtu');
    }

    // Update Data Orang Tua
    public function updateOrtu(DataOrtuRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $ortu = DataOrangTua::where('user_id', $id)->first();
            // Data Ayah
            $ortu->nama_ayah        = $request->nama_ayah;
            $ortu->pekerjaan_ayah   = $request->pekerjaan_ayah;
            $ortu->pendidikan_ayah  = $request->pendidikan_ayah;
            $ortu->telp_ayah        = $request->telp_ayah;
            $ortu->alamat_ayah      = $request->nama_ayah;

            // Data Ibu
            $ortu->nama_ibu         = $request->nama_ibu;
            $ortu->pekerjaan_ibu    = $request->pekerjaan_ibu;
            $ortu->pendidikan_ibu   = $request->pendidikan_ibu;
            $ortu->telp_ibu         = $request->telp_ibu;
            $ortu->alamat_ibu       = $request->nama_ibu;
            $ortu->update();

            if ($ortu) {
                $berkas = new BerkasMurid();
                $berkas->user_id    = $id;
                $berkas->save();
            }

            DB::commit();
            Session::flash('success','Success, Data Berhasil dikirim !');
            return redirect('/ppdb/form-berkas');
        } catch (ErrorException $e) {
            DB::rollback();
            throw new ErrorException($e->getMessage());
        }
    }

    // Berkas View
    public function berkasView()
    {
        $berkas = BerkasMurid::where('user_id', Auth::id())->first();
        // Jika data berkas sudah terisi
        if ($berkas->ktp_orangtua) {
            Session::flash('error','Data kamu sudah lengkap !');
            return redirect('/home');
        }
        return view('ppdb::backend.pendaftaran.berkas', compact('berkas'));
    }

    // Berkas Store
    public function berkasStore(BerkasMuridRequest $request, $id)
    {
        try {
            DB::beginTransaction();
    
            $imageKk = $request->file('kartu_keluarga');
            $kartuKeluarga = time() . "_" . $imageKk->getClientOriginalName();
            $tujuan_upload = 'storage/images/berkas_murid';
            $imageKk->storeAs('public/images/berkas_murid', $kartuKeluarga);
    
            $imageakte = $request->file('akte_kelahiran');
            $akteKelahiran = time() . "_" . $imageakte->getClientOriginalName();
            $imageakte->storeAs('public/images/berkas_murid', $akteKelahiran);
    
            $imagektp = $request->file('ktp');
            $ktp = time() . "_" . $imagektp->getClientOriginalName();
            $imagektp->storeAs('public/images/berkas_murid', $ktp);
    
            $imagefoto = $request->file('foto');
            $foto = time() . "_" . $imagefoto->getClientOriginalName();
            $imagefoto->storeAs('public/images/berkas_murid', $foto);
    
            $berkas = BerkasMurid::find($id);
            $berkas->kartu_keluarga  = $kartuKeluarga;
            $berkas->akte_kelahiran  = $akteKelahiran;
            $berkas->ktp    = $ktp;
            $berkas->foto            = $foto;
            $berkas->save();
    
            DB::commit();
            Session::flash('success', 'Success, Data Berhasil dikirim !');
            return redirect('/home');
        } catch (ErrorException $e) {
            DB::rollback();
            throw new ErrorException($e->getMessage());
        }    }
    

}
