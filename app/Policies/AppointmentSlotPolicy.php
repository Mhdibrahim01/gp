<?php

namespace App\Policies;

use App\Models\AppointmentSlot;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentSlotPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin')|| $user->hasRole('centersup');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AppointmentSlot $appointmentSlot): bool
    {
        $center_id=Auth()->user()->center->id;
        
        return $user->hasRole('admin') || $user->hasRole('centersup') && $appointmentSlot->center_id==$center_id ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') ;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AppointmentSlot $appointmentSlot): bool
    {
        return $user->hasRole('admin')|| $user->hasRole('centersup');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AppointmentSlot $appointmentSlot): bool
    {
        return $user->hasRole('admin')|| $user->hasRole('centersup');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AppointmentSlot $appointmentSlot): bool
    {
        return $user->hasRole('admin') ;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AppointmentSlot $appointmentSlot): bool
    {
        return $user->hasRole('admin')|| $user->hasRole('centersup');

    }
}
