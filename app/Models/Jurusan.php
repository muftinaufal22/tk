<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'pelajaran',
        'kelas_id',
        'is_active'
    ];

    /**
     * Get the class that owns the schedule.
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Get the associated jurusan data.
     */
    public function dataJurusan()
    {
        return $this->hasOne(DataJurusan::class);
    }
}
