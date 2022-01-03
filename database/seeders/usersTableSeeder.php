<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =  User::create([
        'name' => 'super_admin',
        'email' => 'super_admin@app.com',
        'password' => Hash::make('123456')

        ]);

        $user->attachRole('super_admin');
    }
}
