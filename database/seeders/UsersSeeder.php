<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'superadmin',
            'nama_lengkap' => "Super Admin",
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
        ]);

    }
}