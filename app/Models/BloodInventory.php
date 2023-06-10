<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodInventory extends Model
{
    use HasFactory;


    public function bloodType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }


    public function donation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    public function getExpiryDateAttribute($value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
