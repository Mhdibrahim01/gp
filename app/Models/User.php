<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    public function canAccessFilament(): bool
    {
        return $this->hasRole('admin') || $this->hasRole('centersup');
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function centers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Center::class);
    }
<<<<<<< HEAD

    public function donor(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Donor::class);
    }

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function center(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Center::class);
    }

    public function getFilamentName(): string
    {
        if ($this->hasRole('admin')) {
            return 'Admin';
        } elseif ($this->hasRole('centersup')) {
            return $this->center->name;
        }
        return 'unknown';
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isCenter(): bool
    {
        return $this->hasRole('centersup');
    }

    public function isDonor(): bool
    {
        return $this->hasRole('donor');
    }

    public function last_appointment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Appointment::class)->latestOfMany();
=======
public function donor(): \Illuminate\Database\Eloquent\Relations\HasOne
{
    return $this->hasOne(Donor::class);
}
public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(Role::class);
}

public function center(): \Illuminate\Database\Eloquent\Relations\HasOne
{
    return $this->hasOne(Center::class);
}
public function getFilamentName(): string
{
    if($this->hasRole('admin')) {
        return 'Admin';
    } elseif($this->hasRole('centersup')) {
        return $this->center->name;
>>>>>>> origin/main
    }
    return 'unknown';
}
<<<<<<< HEAD
=======
public function isAdmin(): bool
{
    return $this->hasRole('admin');
}
public function isCenter(): bool
{
    return $this->hasRole('centersup');
}
public function isDonor(): bool
{
    return $this->hasRole('donor');
}
public function last_appointment(): \Illuminate\Database\Eloquent\Relations\HasOne
{
    return $this->hasOne(Appointment::class)->latestOfMany();
}
}
>>>>>>> origin/main
