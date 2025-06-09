<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PPDController extends Controller
{
    public function index()
    {
        // Menampilkan status PPD (terbuka atau tertutup)
        $status = $this->getPPDStatus();
        return view('ppd.index', compact('status'));
    }

    public function openPPD()
    {
        // Membuka PPD
        $this->setPPDStatus(true);
        return redirect()->route('ppd.index')->with('status', 'PPD berhasil dibuka!');
    }

    public function closePPD()
    {
        // Menutup PPD
        $this->setPPDStatus(false);
        return redirect()->route('ppd.index')->with('status', 'PPD berhasil ditutup!');
    }

    private function getPPDStatus()
    {
        // Mengambil status PPD, bisa dari database atau session
        return session('ppd_status', false); // Default PPD tertutup
    }

    private function setPPDStatus($status)
    {
        // Menyimpan status PPD ke session atau database
        session(['ppd_status' => $status]);
    }
}