<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    public function bloodType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function donations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Donation::class);
    }

    public function getGenderAttribute($value): string
    {
        if ($value === 'male') {
            return 'ذكر';
        } elseif ($value === 'female') {
            return 'أنثى';
        } 
        else{
            return 'غير محدد';
        }
    }

}
