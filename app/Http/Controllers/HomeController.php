<?php

namespace App\Http\Controllers;

use App\Models\dataMurid;
use App\Models\Events;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Perpustakaan\Entities\Book;
use Modules\Perpustakaan\Entities\Borrowing;
use Modules\Perpustakaan\Entities\Member;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role;

        if (Auth::check()) {
            // DASHBOARD ADMIN \\
            if ($role == 'Admin') {

              $guru = User::where('role','Guru')->where('status','Aktif')->count();
              $murid = User::where('role','Murid')->where('status','Aktif')->count();
              $alumni = User::where('role','Alumni')->where('status','Aktif')->count();
              $acara = Events::where('is_active','0')->count();
              
              // Ambil event berdasarkan jenis_event
              $event = Events::where('is_active','0')
                             ->where('jenis_event','1')
                             ->orderBy('created_at','desc')
                             ->first();
                             
              $event2 = Events::where('is_active','0')
                              ->where('jenis_event','2')
                              ->orderBy('created_at','desc')
                              ->first();
                              
              $event3 = Events::where('is_active','0')
                              ->where('jenis_event','3')
                              ->orderBy('created_at','desc')
                              ->first();
              
              // Data untuk perpustakaan (gunakan try-catch untuk handle jika module tidak ada)
              try {
                  $book = Book::sum('stock');
                  $borrow = Borrowing::whereNull('lateness')->count();
                  $member = Member::where('is_active',0)->count();
              } catch (\Exception $e) {
                  // Jika module perpustakaan tidak tersedia
                  $book = 0;
                  $borrow = 0;
                  $member = 0;
              }

              // PENTING: Pastikan semua variable ada di compact
              return view('backend.website.home', compact(
                  'guru',
                  'murid', 
                  'alumni',
                  'event',
                  'event2',    // Tambah ini
                  'event3',    // Tambah ini
                  'acara',
                  'book',
                  'borrow',
                  'member'
              ));

            }
            // DASHBOARD MURID \\
            elseif ($role == 'Murid') {
              $auth = Auth::id();

              // PERBAIKAN: Ambil event berdasarkan jenis_event (sama seperti Admin & Guru)
              $event = Events::where('is_active','0')
                             ->where('jenis_event','1')
                             ->orderBy('created_at','desc')
                             ->first();
                             
              $event2 = Events::where('is_active','0')
                              ->where('jenis_event','2')
                              ->orderBy('created_at','desc')
                              ->first();
                              
              $event3 = Events::where('is_active','0')
                              ->where('jenis_event','3')
                              ->orderBy('created_at','desc')
                              ->first();
              
              try {
                  $lateness = Borrowing::with('members')
                  ->when(isset($auth), function($q) use($auth){
                    $q->whereHas('members', function($a) use($auth){
                      switch ($auth) {
                        case $auth:
                         $a->where('user_id', Auth::id());
                          break;
                      }
                    });
                  })
                  ->whereNull('lateness')
                  ->count();

                  $pinjam = Borrowing::with('members')
                  ->when(isset($auth), function($q) use($auth){
                    $q->whereHas('members', function($a) use($auth){
                      switch ($auth) {
                        case $auth:
                         $a->where('user_id', Auth::id());
                          break;
                      }
                    });
                  })
                  ->count();
              } catch (\Exception $e) {
                  $lateness = 0;
                  $pinjam = 0;
              }

              // PENTING: Pastikan semua variable event ada di compact
              return view('murid::index', compact('event','event2','event3','lateness','pinjam'));

            }

            elseif ($role == 'Guru' || $role == 'Staf') {

              // Data statistik (sama seperti Admin)
              $guru = User::where('role','Guru')->where('status','Aktif')->count();
              $murid = User::where('role','Murid')->where('status','Aktif')->count();
              $alumni = User::where('role','Alumni')->where('status','Aktif')->count();
              $acara = Events::where('is_active','0')->count();
              
              // Ambil event berdasarkan jenis_event (sama seperti Admin)
              $event = Events::where('is_active','0')
                             ->where('jenis_event','1')
                             ->orderBy('created_at','desc')
                             ->first();
                             
              $event2 = Events::where('is_active','0')
                              ->where('jenis_event','2')
                              ->orderBy('created_at','desc')
                              ->first();
                              
              $event3 = Events::where('is_active','0')
                              ->where('jenis_event','3')
                              ->orderBy('created_at','desc')
                              ->first();

              // Data untuk perpustakaan (sama seperti Admin)
              try {
                  $book = Book::sum('stock');
                  $borrow = Borrowing::whereNull('lateness')->count();
                  $member = Member::where('is_active',0)->count();
              } catch (\Exception $e) {
                  $book = 0;
                  $borrow = 0;
                  $member = 0;
              }

              // Kirim semua variable (sama seperti Admin) 
              return view('backend.website.home', compact(
                  'guru',
                  'murid', 
                  'alumni',
                  'event',
                  'event2',
                  'event3',
                  'acara',
                  'book',
                  'borrow',
                  'member'
              ));

            }
            // DASHBOARD PPDB & PENDAFTAR \\
            elseif($role == 'Guest' || $role == 'PPDB') {

              $register = dataMurid::whereNotIn('proses',['Murid','Ditolak'])->whereYear('created_at', Carbon::now())->count();
              $needVerif = dataMurid::whereNotNull(['tempat_lahir','tgl_lahir','agama'])->whereNull('nisn')->count();
              return view('ppdb::backend.index', compact('register','needVerif'));

            }
            // DASHBOARD PERPUSTAKAAN \\
            elseif ($role == 'Perpustakaan') {

              try {
                  $book = Book::sum('stock');
                  $borrow = Borrowing::whereNull('lateness')->count();
                  $member = Member::where('is_active',0)->count();
                  $members = Member::count();
              } catch (\Exception $e) {
                  $book = 0;
                  $borrow = 0;
                  $member = 0;
                  $members = 0;
              }
              
              return view('perpustakaan::index', compact('book','borrow','member','members'));
            }

            // DASHBOARD BENDAHARA \\
            elseif ($role == 'Bendahara') {
              return view('spp::index');
            }
        }
    }

   
}
