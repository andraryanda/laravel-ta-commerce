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
            'phone' => '08531400779',
            'alamat' => 'Jl. Raya Cikarang Cibarusah No. 27, Cikarang Utara, Bekasi, Jawa Barat 17530',
            'roles' => 'ADMIN',
            'password' => Hash::make('password'),
        ])->markEmailAsVerified();

        foreach (range(1, 5) as $number) {
            $phoneNumber = '0' . substr($faker->unique()->e164PhoneNumber, 3);
            User::updateOrCreate([
                'email' => 'admin' . $number . '@admin.com',
            ], [
                'name' => 'Admin' . $number,
                'username' => $faker->unique()->userName,
                'phone' => $phoneNumber,
                'alamat' => $faker->address,
                'roles' => 'ADMIN',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ])->markEmailAsVerified();
        }


        // $this->command->info('Seeder User berhasil dijalankan.');
    }
}
