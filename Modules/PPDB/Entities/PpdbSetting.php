<?php

namespace Modules\PPDB\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PpdbSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_buka',
        'tanggal_tutup',
        'is_active',
        'pesan_nonaktif'
    ];
    
    /**
     * Check if PPDB registration is currently open
     * 
     * @return bool
     */
    public static function isOpen()
    {
        $setting = self::first();
        
        // If no settings exist or PPDB is not active, return false
        if (!$setting || !$setting->is_active) {
            return false;
        }
        
        $today = now()->format('Y-m-d');
        
        // If both dates are set, check if today is within range
        if ($setting->tanggal_buka && $setting->tanggal_tutup) {
            return $today >= $setting->tanggal_buka && $today <= $setting->tanggal_tutup;
        }
        
        // If only opening date is set, check if today is after or equal to opening date
        if ($setting->tanggal_buka && !$setting->tanggal_tutup) {
            return $today >= $setting->tanggal_buka;
        }
        
        // If only closing date is set, check if today is before or equal to closing date
        if (!$setting->tanggal_buka && $setting->tanggal_tutup) {
            return $today <= $setting->tanggal_tutup;
        }
        
        // If no dates are set but is_active is true, PPDB is open
        return true;
    }
    
    /**
     * Get message to display when PPDB is closed
     * 
     * @return string
     */
    public static function getClosedMessage()
    {
        $setting = self::first();
        
        if ($setting && $setting->pesan_nonaktif) {
            return $setting->pesan_nonaktif;
        }
        
        return 'Pendaftaran PPDB saat ini ditutup.';
    }
}
