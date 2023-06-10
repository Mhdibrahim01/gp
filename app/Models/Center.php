<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Center extends Model
{
    use HasFactory;
    use HasRoles;

    public function donation(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Donation::class);
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function city(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(City::class);
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function appointmentSlots(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AppointmentSlot::class);
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function government(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Government::class);
    }

}
