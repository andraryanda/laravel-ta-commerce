<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'owner@owner.com',
        ], [
            'name' => 'Owner',
            'username' => 'owner',
            'phone' => '085314005779',
            'alamat' => 'Jl. Raya Cikarang Cibarusah No. 27, Cikarang Utara, Bekasi, Jawa Barat 17530',
            'roles' => 'OWNER',
            'password' => Hash::make('password'),
        ])->markEmailAsVerified();
    }
}
