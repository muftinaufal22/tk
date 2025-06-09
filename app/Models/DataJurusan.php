<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJurusan extends Model
{
    use HasFactory;

    protected $table = 'data_jurusans';

    protected $fillable = ['kelas_id'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}


