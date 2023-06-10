<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    use HasFactory;
    public function cities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(City::class);
    }

    public function centers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Center::class);
    }

}
