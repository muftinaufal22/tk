<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPPDStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Mengambil status PPD dari session atau database
        $status = session('ppd_status', false); // false berarti tertutup

        // Jika PPD tertutup, arahkan ke halaman "PPDB Berakhir"
        if (!$status) {
            return redirect()->route('ppd.closed');
        }

        return $next($request);
    }
}