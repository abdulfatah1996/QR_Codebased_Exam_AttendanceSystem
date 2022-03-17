<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    //php artisan migrate:fresh
    //php artisan db:seed
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'administrator@gmail.com',
            'password' => Hash::make('administrator'),
            'role' => 'Administrator',
            'created_at' => date(now()),
            'updated_at' => date(now()),
        ]);
        DB::table('users')->insert([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('teacher'),
            'role' => 'Teacher',
            'created_at' => date(now()),
            'updated_at' => date(now()),
        ]);
    }
}
