<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = 'events';
    
    protected $fillable = [
        'title',
        'slug',
        'desc',
        'jenis_event',
        'acara',
        'lokasi',
        'is_active'
    ];

    protected $casts = [
        'acara' => 'datetime',
        'is_active' => 'boolean'
    ];

    // Scope untuk filter berdasarkan jenis event
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_event', $jenis);
    }

    // Scope untuk event aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', 0);
    }
}