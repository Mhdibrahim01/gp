<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;
    use SoftDeletes;


    public function donor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function getTotalDonationsAttribute()
    {
        return $this->donations()->count();
    }

    public function approve()
    {
        $this->is_approved = true;
        $this->save();
    }


    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id', 'id');
    }
 

    public function donorName(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {

        return $this->hasOneThrough(User::class, Donor::class, 'id', 'id', 'donor_id', 'user_id');
    }

    public function blood_test(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(BloodTest::class);
    }

    public function blood_type(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(BloodType::class, Donor::class, 'blood_type_id', 'id', 'donor_id', 'blood_type_id');
    }

}
