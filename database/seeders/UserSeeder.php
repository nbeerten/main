<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => config('misc.admin.name'),
            'github_username' => config('misc.admin.github_username'),
            'email' => config('misc.admin.email'),
            'password' => Hash::make(config('misc.admin.password')),
        ]);
    }
}
