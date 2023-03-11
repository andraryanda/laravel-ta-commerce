<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //digunakan untuk menandai excel dengan header

class UserAllImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'      => $row['name'],
            'email'     => $row['email'],
            'username'  => $row['username'],
            'password'  => Hash::make($row['password']),
            'phone'  => $row['phone'],
            'roles'  => $row['roles'],
        ]);
    }
}
