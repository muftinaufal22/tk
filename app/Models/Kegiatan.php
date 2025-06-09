<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatans';
    
    protected $fillable = [
        'nama_kegiatan',
        'gambar',
        'tanggal',
        'deskripsi'
    ];
}

// File: app/Http/Requests/KegiatanRequest.php
