<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $fillable = [
        'campus_id',
        'first_name',
        'last_name',
        'profile',
        'email',
        'password',
        'phone',
        'avatar_path',
        'role',
        'status',
        'preferred_currency',
        'locale',
        'last_login_at',
        'language',
    ];
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn() => trim("{$this->first_name} {$this->last_name}")
        );
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
    }



    public function showUserProfile(): string
    {
        if (!$this->profile) {
            return asset('photos/default_user.png');
        }
        $path = 'uploads/users/' . $this->profile;
        if (!Storage::disk('public')->exists($path)) {
            return asset('photos/default_user.png');
        }
        return Storage::disk('public')->url($path);
    }
}
