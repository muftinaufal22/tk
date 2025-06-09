<?php

// namespace App\Http\Controllers\Backend\Website;

// use App\Http\Controllers\Controller;
// use App\Models\Penerimaan; 
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Session;

// class PenerimaanController extends Controller
// {
//     public function index()
//     {
        
//         $penerimaan = Penerimaan::all();
//         return view('backend.website.penerimaan.index', compact('penerimaan'));
//     }

//     public function create()
//     {
//         return view('backend.website.penerimaan.create');
//     }

//     public function store(Request $request)
//     {
//         try {
//             DB::beginTransaction();

//             $penerimaan = new Penerimaan();
//             $penerimaan->tanggal_penerimaan = $request->tanggal_penerimaan;
//             $penerimaan->status_penerimaan = $request->status_penerimaan;
//             $penerimaan->keterangan = $request->keterangan;
//             $penerimaan->save();

//             DB::commit();
//             Session::flash('success', 'Penerimaan Siswa Berhasil Ditambahkan!');
//             return redirect()->route('penerimaan.index');
//         } catch (\Exception $e) {
//             DB::rollback();
//             Session::flash('error', 'Gagal menambahkan Penerimaan: ' . $e->getMessage());
//             return redirect()->route('penerimaan.index');
//         }
//     }

//     public function edit($id)
//     {
//         $penerimaan = Penerimaan::findOrFail($id);
//         return view('backend.website.penerimaan.edit', compact('penerimaan'));
//     }

//     public function update(Request $request, $id)
//     {
//         try {
//             DB::beginTransaction();

//             $penerimaan = Penerimaan::findOrFail($id);
//             $penerimaan->tanggal_penerimaan = $request->tanggal_penerimaan;
//             $penerimaan->status_penerimaan = $request->status_penerimaan;
//             $penerimaan->keterangan = $request->keterangan;
//             $penerimaan->save();

//             DB::commit();
//             Session::flash('success', 'Penerimaan Siswa Berhasil Diperbarui!');
//             return redirect()->route('penerimaan.index');
//         } catch (\Exception $e) {
//             DB::rollback();
//             Session::flash('error', 'Gagal memperbarui Penerimaan: ' . $e->getMessage());
//             return redirect()->route('penerimaan.index');
//         }
//     }

//     public function destroy($id)
//     {
//         try {
//             DB::beginTransaction();

//             $penerimaan = Penerimaan::findOrFail($id);
//             $penerimaan->delete();

//             DB::commit();
//             Session::flash('success', 'Penerimaan Siswa Berhasil Dihapus!');
//             return redirect()->route('penerimaan.index');
//         } catch (\Exception $e) {
//             DB::rollback();
//             Session::flash('error', 'Gagal menghapus Penerimaan: ' . $e->getMessage());
//             return redirect()->route('penerimaan.index');
//         }
//     }
// }