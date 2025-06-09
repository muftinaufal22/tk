<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Perpustakaan\Entities\Member;
use Modules\PPDB\Entities\BerkasMurid;
use Modules\PPDB\Entities\DataOrangTua;
use Modules\SPP\Entities\BankAccount;
use Modules\SPP\Entities\PaymentSpp;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name', 'username', 'role', 'status', 'foto_profile', 'email', 'password', 'kelas_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user's general detail (if you have a generic UsersDetail model).
     * This might be redundant if 'muridDetail' covers all student-specific details.
     */
    public function userDetail()
    {
        return $this->hasOne(UsersDetail::class, 'user_id', 'id');
    }

    /**
     * Get the student-specific details associated with the user.
     */
    public function muridDetail()
    {
        // Assuming 'dataMurid' is specifically for student details and linked by 'user_id'
        return $this->hasOne(dataMurid::class, 'user_id', 'id');
    }

    /**
     * Get the parent/guardian data associated with the user (student).
     * Ensure 'DataOrangTua' model exists in 'Modules\PPDB\Entities'.
     */
    public function dataOrtu()
    {
        return $this->hasOne(DataOrangTua::class, 'user_id', 'id');
    }

    /**
     * Get the student's document files.
     * Ensure 'BerkasMurid' model exists in 'Modules\PPDB\Entities'.
     */
    public function berkas()
    {
        return $this->hasOne(BerkasMurid::class, 'user_id', 'id');
    }

    /**
     * Get the library member record associated with the user.
     * Ensure 'Member' model exists in 'Modules\Perpustakaan\Entities'.
     */
    public function member()
    {
        return $this->hasOne(Member::class, 'user_id', 'id');
    }

    /**
     * Get the latest/primary payment record associated with the user.
     * If a user can have multiple payments, consider a hasMany relationship.
     * Ensure 'PaymentSpp' model exists in 'Modules\SPP\Entities'.
     */
    public function payment()
    {
        // If a user can have multiple payments, this should be hasMany.
        // If it's for a single, primary payment, then hasOne is fine.
        return $this->hasOne(PaymentSpp::class, 'user_id', 'id');
    }

    /**
     * Get the user's primary bank account.
     * This might be redundant if 'banks' covers all bank accounts.
     * Consider removing this if 'banks' is the intended relationship for multiple accounts.
     * Ensure 'BankAccount' model exists in 'Modules\SPP\Entities'.
     */
    public function bank()
    {
        return $this->hasOne(BankAccount::class, 'user_id', 'id');
    }

    /**
     * Get all bank accounts associated with the user.
     * This seems more appropriate if a user can have multiple bank accounts.
     */
    public function banks()
    {
        return $this->hasMany(BankAccount::class, 'user_id', 'id');
    }

    /**
     * Get the user's settings.
     * Ensure 'Setting' model is correctly namespaced (e.g., App\Models\Setting).
     */
    public function setting()
    {
        // Assuming 'Setting' is in the App\Models namespace or specify its full path
        return $this->hasOne(Setting::class, 'user_id', 'id');
    }

    /**
     * Get the class the user (student) belongs to.
     * Ensure 'Kelas' model is correctly namespaced (e.g., App\Models\Kelas).
     */
    public function kelas()
    {
        // Assuming 'Kelas' is in the App\Models namespace or specify its full path
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
