<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $user = User::create([
            'username' => 'superadmin',
            'nama_lengkap' => 'superadmin',
            'password' => bcrypt('123456'),
            'remember_token' => Str::random(10),
        ]);
        for($i = 1; $i <= 10; $i++){
            $user = User::create([
                'username' => $faker->username,
                'nama_lengkap' => $faker->name,
                'password' => bcrypt('123456'),
                'remember_token' => Str::random(10),
            ]);
        };
    }
}