<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class centerCommand extends Command
{
   
        protected $signature = 'assign:center-role';
    
        protected $description = 'Assign the "center" role to users who have a corresponding entry in the "centers" table.';
    
        public function handle()
        {
            $users = User::whereHas('center')->get();
    
            foreach ($users as $user) {
                $user->assignRole('centersup');
            }
    
            $this->info('The "center" role has been assigned to ' . $users->count() . ' users.');
        }
    }

