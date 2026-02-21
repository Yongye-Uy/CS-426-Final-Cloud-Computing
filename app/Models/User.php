<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization',
        'phone',
        'role_id',
        'verification_code',
        'verification_code_expires_at',
        'is_verified',
        'verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verification_code_expires_at' => 'datetime',
            'verified_at' => 'datetime',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->role && $this->role->isAdmin();
    }

    /**
     * Check if user is regular user
     */
    public function isUser()
    {
        return $this->role && $this->role->isUser();
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Generate a verification code
     */
    public function generateVerificationCode()
    {
        $this->verification_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->verification_code_expires_at = Carbon::now()->addMinutes(15);
        $this->save();
        
        return $this->verification_code;
    }

    /**
     * Verify the user with the provided code
     */
    public function verifyCode($code)
    {
        if ($this->verification_code === $code && 
            $this->verification_code_expires_at && 
            Carbon::now()->isBefore($this->verification_code_expires_at)) {
            
            $this->is_verified = true;
            $this->verified_at = Carbon::now();
            $this->verification_code = null;
            $this->verification_code_expires_at = null;
            $this->save();
            
            return true;
        }
        
        return false;
    }

    /**
     * Check if verification code is expired
     */
    public function isVerificationCodeExpired()
    {
        return !$this->verification_code_expires_at || 
               Carbon::now()->isAfter($this->verification_code_expires_at);
    }

    /**
     * Check if user needs verification
     */
    public function needsVerification()
    {
        return !$this->is_verified;
    }

    /**
     * Get the campaigns created by this user
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'created_by');
    }

    /**
     * Get the campaigns approved by this user (for admins)
     */
    public function approvedCampaigns()
    {
        return $this->hasMany(Campaign::class, 'approved_by');
    }
}
