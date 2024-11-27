<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'invite_code',
        'password',
        'role',
        'referrer_id',
        'product_id',
        'level_id',
        'balance',
        'balance_lock',
        'total_deposit',
        'total_withdraw',
        'total_order',
        'order_number',
        'status',
        'bank_name',
        'bank_account',
        'bank_owner',
        'bank_number',
        'password2',
        'address',
        'avatar',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role == 'admin';
    }

    public function getFilamentName(): string
    {
        return $this->full_name;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $appends = ['invite_number'];

    public function getInviteNumberAttribute()
    {
        return $this->hasMany(User::class, 'referrer_id')->count();
    }

}
