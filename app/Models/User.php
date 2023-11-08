<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'company_id',
        'name',
        'email',
        'password',
        'status',
        'deleted',
        'two_factor_code',
        'two_factor_expires_at',
        'user_key'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function role()
    {
        
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->role ? $this->role->roleHasPermissions() : null;
    }
    
    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token, $this));
    }

    //This function is use to generate two factor code
    public function generateTwoFactorCode()
    {
        $twoFactorCode = random_int(100000, 999999);
        $this->timestamps = false;
        $this->two_factor_code = $twoFactorCode;
        $this->two_factor_expires_at = Carbon::now()->addMinutes(5);
        $this->user_key = Str::random(16);
        $this->save();

        return $twoFactorCode;
    }

    //This function is use to reset two factor code.
    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->user_key = null;
        $this->save();
    }

}
