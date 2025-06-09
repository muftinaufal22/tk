<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    
    protected $fillable = [
        'nama'
    ];

    /**
     * Get the students in this class.
     */
        public function murid()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }

    /**
     * Get the schedules for this class.
     */
    public function jadwal()
    {
        return $this->hasMany(Jurusan::class, 'kelas_id');
    }
}
