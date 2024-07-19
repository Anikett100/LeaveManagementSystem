<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(2)->create();

        // User::factory()->create([
        //     'name' => 'Aniket',
        //     'email' => 'aniket@gmail.com',
        //     'password'=>'aniket@123'
            
        // ]);
        $users = [
            [
                'name' => 'Aniket',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user@123'),
            ],
            [
                'name' => 'Sankalp',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('manager@123'),
            ],
            [
                'name' => 'Kartik',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123'),
            ],
           
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
