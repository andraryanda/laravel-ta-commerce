<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //digunakan untuk menandai excel dengan header

class UserCustomerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $validator = Validator::make($row, [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
            'username' => [
                'required',
                Rule::unique('users', 'username')
            ],
            'password' => 'required|min:8',
            'phone' => [
                'nullable',
                'integer',
                'regex:/^[0-9]*$/'
            ],
            'roles' => 'required|string|max:255|in:USER'
        ], $this->customValidationMessages());

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first() ?? 'Validation Error!');
        }

        if ($row['roles'] == 'USER') {
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
    /**
     * @return array
     */
    public function customValidationMessages()
    {

        return [
            // Definisikan pesan error yang akan ditampilkan jika validasi gagal
            'name.required'     => 'Kolom nama tidak boleh kosong',
            'name.string'       => 'Kolom nama harus berupa teks',

            'email.required'    => 'Kolom email tidak boleh kosong',
            'email.email'       => 'Kolom email harus berisi alamat email yang valid',
            'email.unique'      => 'Alamat email sudah digunakan oleh pengguna lain',

            'username.required' => 'Kolom username tidak boleh kosong',
            'username.string'   => 'Kolom username harus berupa teks',
            'username.unique'   => 'Username sudah digunakan oleh pengguna lain',

            'password.required' => 'Kolom password tidak boleh kosong',
            'password.string'   => 'Kolom password harus berupa teks',
            'password.min'      => 'Password minimal harus terdiri dari 8 karakter',

            'phone.required'    => 'Kolom nomor telepon tidak boleh kosong',
            'phone.string'      => 'Kolom nomor telepon harus berupa angka',
            'phone.regex'       => 'Format nomor telepon tidak valid',

            'roles.required'    => 'Kolom role tidak boleh kosong',
            // 'roles.in'          => 'Role harus salah satu dari ADMIN atau USER',
            'roles.in' => 'Sepertinya Anda salah menginput Nilai :attribute (:input). Harusnya anda menginputkan USER.'

        ];
    }
}
