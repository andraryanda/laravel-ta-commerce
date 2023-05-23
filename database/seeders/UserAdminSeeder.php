<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserAdminSeeder extends Seeder
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
            'email' => 'admin@admin.com',
        ], [
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '',
            'roles' => 'ADMIN',
            'password' => Hash::make('password'),
        ])->markEmailAsVerified();

        foreach (range(1, 5) as $item) {
            User::updateOrCreate([
                'email' => 'admin' . $item . '@admin.com',

            ], [
                'name' => 'Admin' . $item,
                'username' => $faker->unique()->userName,
                'phone' => $faker->phoneNumber,
                'roles' => 'ADMIN',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->markEmailAsVerified();
        }

        // $this->command->info('Seeder User berhasil dijalankan.');
    }
}
