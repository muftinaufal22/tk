<?php

namespace App\Http\Controllers\Backend\Website;

use App\Http\Controllers\Controller;
use App\Models\dataMurid;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProgramRequest;
use App\Models\DataJurusan;
use ErrorException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index(Request $request)
    {
 $user = auth()->user();
        if($user->role === 'murid') {
            $jurusan = Jurusan::with('kelas')
                ->where('kelas_id', $user->kelas_id)
                ->orderBy('created_at', 'desc')
                ->get();
            $kelas = Kelas::where('id', $user->kelas_id)->get();
            $selectedKelas = $user->kelas_id;
        } else {
            $kelas = Kelas::all();
            $selectedKelas = $request->get('kelas_id');
            
            $jurusan = Jurusan::with('kelas')
                ->when($selectedKelas, function($query) use ($selectedKelas) {
                    return $query->where('kelas_id', $selectedKelas);
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }
            
        return view('backend.website.program.index', compact('jurusan', 'kelas', 'selectedKelas'));
    }
    
    public function muridA(Request $request)
    {
        $kelas = Kelas::where('nama', 'kelas A')->firstOrFail();
        $murid = User::where('role', 'murid')
                    ->where('kelas_id', $kelas->id)
                    ->with('muridDetail')
                    ->get();
        
        return view('backend.website.program.kelas', compact('murid', 'kelas'));
    }

    public function muridB(Request $request)
    {

        $kelas = Kelas::where('nama', 'kelas B')->firstOrFail();
        $murid = User::where('role', 'murid')
                    ->where('kelas_id', $kelas->id)
                    ->with('muridDetail')
                    ->get();
        
        return view('backend.website.program.kelas', compact('murid', 'kelas'));
    }

    public function showKelasA()
    {
        $kelas = Kelas::where('nama', 'kelas A')->first();
        $jurusan = Jurusan::with('kelas')
            ->where('kelas_id', $kelas->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('backend.website.program.guru', compact('jurusan', 'kelas'));
    }

    public function showKelasB()
    {
        $kelas = Kelas::where('nama', 'kelas B')->first();
        $jurusan = Jurusan::with('kelas')
            ->where('kelas_id', $kelas->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('backend.website.program.guru', compact('jurusan', 'kelas'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('backend.website.program.create', compact('kelas'));   

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgramRequest $request)
    {
        try {
            $jurusan = new Jurusan;
            $jurusan->hari = $request->hari;
            $jurusan->jam_mulai = $request->jam_mulai;
            $jurusan->jam_selesai = $request->jam_selesai;
            $jurusan->pelajaran = $request->pelajaran;
            $jurusan->kelas_id = $request->kelas;
            $jurusan->is_active = $request->is_active ?? 0;
            $jurusan->save();

            Session::flash('success','Jadwal Pelajaran Berhasil ditambah !');
            return redirect()->route('program-studi.index');

        } catch (ErrorException $e) {
            Session::flash('error', 'Jadwal Pelajaran Gagal ditambah!');
            Log::error('Error storing Program: ' . $e->getMessage());
            throw new ErrorException($e->getMessage());
        }  

    }       

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
        $jurusan = Jurusan::with('dataJurusan')->findOrFail($id);

        $kelas = Kelas::all();
        return view('backend.website.program.edit', compact('jurusan', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */




    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Temukan data jurusan berdasarkan ID
            $jurusan = Jurusan::findOrFail($id);
            $jurusan->hari = $request->hari;
            $jurusan->jam_mulai = $request->jam_mulai;
            $jurusan->jam_selesai = $request->jam_selesai;
            $jurusan->pelajaran = $request->pelajaran;
            $jurusan->kelas_id = $request->kelas;
            $jurusan->is_active = $request->is_active;
            $jurusan->save();

            DB::commit();
            Session::flash('success', 'Jadwal Pelajaran Berhasil diupdate!');
            return redirect()->route('program-studi.index');

        } catch (ErrorException $e) {
            DB::rollback();
            Session::flash('error', 'Jadwal Pelajaran Gagal diupdate!');
            throw new ErrorException($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $jurusan = Jurusan::findOrFail($id);
            $dataJurusan = DataJurusan::where('jurusan_id', $id)->first();

            // Hapus gambar jika ada
            if ($dataJurusan && $dataJurusan->image && \Storage::exists('public/images/jurusan/' . $dataJurusan->image)) {
                \Storage::delete('public/images/jurusan/' . $dataJurusan->image);
            }

            // Hapus data terkait
            if ($dataJurusan) {
                $dataJurusan->delete();
            }

            // Hapus data jurusan utama
            $jurusan->delete();

            DB::commit();
            return redirect()->route('program-studi.index')->with('success', 'Jadwal Pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            // Log error here
            Log::error('Error deleting Program: ' . $e->getMessage());
            return redirect()->route('program-studi.index')->with('error', 'Gagal menghapus Program Studi: ' . $e->getMessage());
        }
    }

    // Show guru's programs
    public function showForGuru()
    {
        $user = auth()->user();
        $kelas_id = request('kelas_id', $user->kelas_id);
       $jurusan = Jurusan::where('kelas_id', $kelas_id)
        ->orderBy('created_at', 'desc')
        ->get();
        $kelasOptions = Kelas::all();
        $kelasObjek = Kelas::find($kelas_id);

        return view('backend.website.program.guru', compact('jurusan', 'kelasOptions', 'kelasObjek', 'kelas_id'));
    }


    // Show murid's programs
   public function showForMurid()
{
    $user = auth()->user();
    $kelas_id = request('kelas_id', $user->kelas_id);
    
    // TAMBAHAN: Validasi keamanan - murid hanya bisa lihat jadwal kelas mereka
    if($user->kelas_id != $kelas_id) {
        abort(403, 'Anda tidak memiliki akses ke jadwal kelas ini');
    }
    
    $jurusan = Jurusan::where('kelas_id', $kelas_id)
        ->orderBy('created_at', 'desc')
        ->get();
        
    $kelasOptions = Kelas::all();
    $kelasObjek = Kelas::find($kelas_id);

    return view('backend.website.program.murid', compact('jurusan', 'kelasOptions', 'kelasObjek', 'kelas_id'));
}

    


    /**
     * Show detail murid for guru (read-only)
     */
    public function showMuridDetail($id)
    {
        $murid = User::with(['muridDetail', 'dataOrtu', 'kelas', 'berkas'])
                    ->where('role', 'murid')
                    ->findOrFail($id);
        
        return view('backend.website.program.detail-murid-guru', compact('murid'));
    }
}
