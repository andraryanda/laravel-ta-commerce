<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // Pengecekan apakah sudah ada data user atau belum
        // if (User::count() > 0) {
        //     $this->command->info('Data user sudah ada pada database. Seeder dibatalkan.');
        //     return;
        // }

        $faker = Faker::create('id_ID');

        User::updateOrCreate([
            'email' => 'andra@gmail.com',
        ], [
            'name' => 'Andraryanda',
            'username' => 'andra',
            'phone' => '085314005779',
            'roles' => 'USER',
            'password' => Hash::make('password'),
        ]);

        for ($i = 0; $i < 10; $i++) {
            User::updateOrCreate([
                'email' => $faker->email,
            ], [
                'name' => $faker->name,
                'username' => $faker->unique()->userName,
                'phone' => $faker->phoneNumber,
                'roles' => 'USER',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        // $this->command->info('Seeder User berhasil dijalankan.');
    }
}
