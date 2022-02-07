<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exists = User::where('email', 'admin@gmail.com')->first();
        if (!$exists) {
            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456789'),
                'status' => '1'
            ]);
            $user->assignRole(['Admin']);
        }
    }
}
