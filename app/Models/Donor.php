<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function bloodType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(BloodType::class);
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
    public function donations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Donation::class);
    }
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function getGenderAttribute($value): string
    {
        if ($value === 'male') {
            return 'ذكر';
        } elseif ($value === 'female') {
            return 'أنثى';
<<<<<<< HEAD
        } else {
=======
        }
        else{
>>>>>>> origin/main
            return 'غير محدد';
        }
    }

}
