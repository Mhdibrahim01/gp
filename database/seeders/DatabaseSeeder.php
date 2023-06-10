<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Donor;
use App\Models\Center;
use App\Models\Donation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


   $user=   User::factory()->create([
    'id'=>60,
            'name' => 'Admin User',
             'email' => 'admin1@admin.php',
         ]);
$user->assignRole('admin'); 
    }
}
