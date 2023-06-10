<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function slot()
    {
        return $this->belongsTo(AppointmentSlot::class, 'appointment_slot_id')->withTrashed();
    }


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function center(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(Center::class, AppointmentSlot::class, 'id', 'id', 'appointment_slot_id', 'center_id');

    }

    public function getFullstatusAttribute()
    {
        return $this->attributes['status'];
    }

    protected $appends = ['fullstatus'];
}
