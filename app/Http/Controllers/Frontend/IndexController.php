<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Berita;
use App\Models\Events;
use App\Models\Footer;
use App\Models\ImageSlider;
use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\KategoriBerita;
use App\Models\Kegiatan;
use App\Models\ProfileSekolah;
use App\Models\User;
use App\Models\Video;
use App\Models\Visimisi;

class IndexController extends Controller
{
    //Welcome
    public function index()
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Gambar Slider
        $slider = ImageSlider::where('is_Active','0')->get();

        // About
        $about = About::where('is_Active','0')->first();

        // Video
        $video = Video::where('is_active','0')->first();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Berita
        $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();

        // Event
        $event = Events::where('is_active','0')->orderBy('created_at','desc')->get();

        // Footer
        $footer = Footer::first();

        return view('frontend.welcome', compact('jurusanM','kegiatanM','slider','about','video','pengajar','berita','event','footer'));
    }

    // Berita
    public function berita(Request $request)
    {
         // Menu
         $jurusanM = Jurusan::where('is_active','0')->get();
         $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();
 
         // Kategori
         $kategori = KategoriBerita::where('is_active','0')->orderBy('created_at','desc')->get();
         
         // Pencarian
         $search = $request->input('search');
         $tanggal = $request->input('tanggal');
         
         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc');
         
         // Kegiatan dengan label baru (kegiatan yang dibuat dalam 7 hari terakhir)
         $kegiatan = Kegiatan::where('is_active','1')
                    ->select('id', 'nama_kegiatan as title', 'gambar as thumbnail', 'tanggal', 'deskripsi', 'created_at')
                    ->selectRaw("'kegiatan' as type")
                    ->selectRaw("DATEDIFF(NOW(), created_at) <= 7 as is_new");
         
         // Filter pencarian jika ada
         if ($search) {
             $berita->where('title', 'like', "%{$search}%");
             $kegiatan->where('nama_kegiatan', 'like', "%{$search}%");
         }
         
         if ($tanggal) {
             $kegiatan->whereDate('tanggal', $tanggal);
         }
         
         // Gabungkan data berita dan kegiatan
         $combinedData = $berita->get()->concat($kegiatan->get())
                        ->sortByDesc('created_at')
                        ->values();
         
         // Paginasi manual
         $perPage = 8;
         $currentPage = $request->input('page', 1);
         $currentItems = $combinedData->forPage($currentPage, $perPage);
         $paginatedItems = new \Illuminate\Pagination\LengthAwarePaginator(
             $currentItems,
             $combinedData->count(),
             $perPage,
             $currentPage,
             ['path' => $request->url(), 'query' => $request->query()]
         );
         
         // Berita terbaru untuk sidebar
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->take(5)->get();
         
         return view('frontend.content.beritaAll', compact('paginatedItems', 'berita', 'kategori', 'jurusanM', 'kegiatanM', 'footer', 'search', 'tanggal'));
    }
    // Show Detail Berita
    public function detailBerita($slug)
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Footer
        $footer = Footer::first();

        // Kategori
        $kategori = KategoriBerita::where('is_active','0')->orderBy('created_at','desc')->get();
        
        // Berita
        $beritaOther = Berita::where('is_active','0')->orderBy('created_at','desc')->get();

        $berita = Berita::where('slug',$slug)->first();
        return view('frontend.content.showBerita', compact('berita','kategori','beritaOther','jurusanM','kegiatanM','footer'));
    }
    
    // Show Detail Kegiatan
    public function detailKegiatan($id)
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Footer
        $footer = Footer::first();
        
        // Berita
        $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->take(5)->get();

        // Kegiatan
        $kegiatan = Kegiatan::findOrFail($id);
        
        // Kegiatan lainnya
        $kegiatanLainnya = Kegiatan::where('is_active','1')
                          ->where('id', '!=', $kegiatan->id)
                          ->orderBy('created_at','desc')
                          ->take(4)
                          ->get();
                          
        return view('frontend.content.detailKegiatan', compact('kegiatan', 'kegiatanLainnya', 'berita', 'jurusanM', 'kegiatanM', 'footer'));
    }


    // Events
    public function events()
    {
         // Menu
         $jurusanM = Jurusan::where('is_active','0')->get();
         $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();
 
         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();
 
         $event = Events::where('is_active','0')->orderBy('created_at','desc')->get();
         return view('frontend.content.event.eventAll', compact('event','berita','jurusanM','kegiatanM','footer'));
    }


    // Detail Event
    public function detailEvent($slug)
    {
        // Menu
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

         // Footer
        $footer = Footer::first();
 
         // Berita
         $berita = Berita::where('is_active','0')->orderBy('created_at','desc')->get();
 
         $event = Events::where('slug',$slug)->first();
         $eventOther = Events::where('is_active','0')->orderBy('created_at','desc')->get();

         return view('frontend.content.event.detailEvent', compact('event','eventOther','berita','jurusanM','kegiatanM','footer'));
    }

    // Profile Sekolah
    public function profileSekolah()
    {
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Footer
        $footer = Footer::first();

        $profile = ProfileSekolah::first();
        return view('frontend.content.profileSekolah', compact('profile','jurusanM','kegiatanM','pengajar','footer'));
    }

    // Visi dan Misi
    public function visimisi()
    {
        $jurusanM = Jurusan::where('is_active','0')->get();
        $kegiatanM = Kegiatan::where('is_active','0')->get();

        // Pengajar
        $pengajar = User::with('userDetail')->where('status','Aktif')->where('role','Guru')->get();

        // Footer
        $footer = Footer::first();

        $visimisi = Visimisi::first();
        return view('frontend.content.visimisi', compact('visimisi','jurusanM','kegiatanM','pengajar','footer'));
    }

}