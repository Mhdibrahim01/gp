<?php

namespace App\Observers;

use App\Models\Center;

class CenterObserver
{
    public function saved(Center $center)
{
    $user = $center->user;

    if ($user) {
        $user->assignRole('centersup');
    }
}
}
