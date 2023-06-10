<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class donorCommand extends Command
{
    protected $signature = 'assign:donor-role';

    protected $description = 'Assign the "donor" role to users who have a corresponding entry in the "donors" table.';

    public function handle()
    {
        $users = User::whereHas('donor')->get();

        foreach ($users as $user) {
            $user->assignRole('donor');
        }

        $this->info('The "donor" role has been assigned to ' . $users->count() . ' users.');
    }
}
