<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentSlot extends Model
{
    use HasFactory;
    use SoftDeletes;
<<<<<<< HEAD

=======
>>>>>>> origin/main
    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function appointments()
    {
        return $this->belongsTo(Appointment::class);
    }
<<<<<<< HEAD

    public function available()
    {
        $this->is_available = true;
        $this->save();
    }

    public function unavailable()
    {
        $this->is_available = false;
        $this->save();
    }
=======
    public function available(){
        $this->is_available = true;
        $this->save();
    }
public function unavailable(){
        $this->is_available = false;
        $this->save();
}
>>>>>>> origin/main

}
