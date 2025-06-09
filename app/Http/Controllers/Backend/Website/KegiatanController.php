<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use App\Http\Requests\KegiatanRequest;
use ErrorException;
use Session;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kegiatan = Kegiatan::all();
        return view('backend.website.kegiatan.index', compact('kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.website.kegiatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\KegiatanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KegiatanRequest $request)
    {
        DB::beginTransaction();
        try {
            $nama_img = null;
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $nama_img = time()."_".$image->getClientOriginalName();
                // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'public/images/kegiatan';
                $image->storeAs($tujuan_upload, $nama_img);
            }

            $kegiatan = new Kegiatan();
            $kegiatan->nama_kegiatan = $request->nama_kegiatan;
            $kegiatan->tanggal       = $request->tanggal;
            $kegiatan->gambar        = $nama_img;
            $kegiatan->deskripsi     = $request->deskripsi;
            $kegiatan->is_active     = $request->is_active;
            $kegiatan->save();

            DB::commit();
            Session::flash('success','Kegiatan Berhasil ditambah !');
            return redirect()->route('backend-kegiatan.index')->with('success', 'Kegiatan berhasil ditambah!');
        } catch (ErrorException $e) {
            DB::rollback();
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kegiatan = Kegiatan::find($id);
        return view('backend.website.kegiatan.edit', compact('kegiatan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\KegiatanRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(KegiatanRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $kegiatan = Kegiatan::findOrFail($id);
            
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($kegiatan->gambar && Storage::exists('public/images/kegiatan/'.$kegiatan->gambar)) {
                    Storage::delete('public/images/kegiatan/'.$kegiatan->gambar);
                }
                
                $image = $request->file('gambar');
                $nama_img = time()."_".$image->getClientOriginalName();
                // isi dengan nama folder tempat kemana file diupload
                $tujuan_upload = 'public/images/kegiatan';
                $image->storeAs($tujuan_upload, $nama_img);
                $kegiatan->gambar = $nama_img;
            }

            $kegiatan->nama_kegiatan = $request->nama_kegiatan;
            $kegiatan->tanggal       = $request->tanggal;
            $kegiatan->deskripsi     = $request->deskripsi;
            $kegiatan->is_active     = $request->is_active;
            $kegiatan->save();

            DB::commit();
            Session::flash('success','Kegiatan Berhasil diupdate !');
            return redirect()->route('backend-kegiatan.index')->with('success', 'Kegiatan berhasil diupdate!');
        } catch (ErrorException $e) {
            DB::rollback();
            Session::flash('error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($kegiatan->gambar && Storage::exists('public/images/kegiatan/'.$kegiatan->gambar)) {
                Storage::delete('public/images/kegiatan/'.$kegiatan->gambar);
            }
            
            $kegiatan->delete();
            
            Session::flash('success','Kegiatan Berhasil dihapus!');
            return redirect()->route('backend-kegiatan.index');
        } catch (ErrorException $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}