<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ],
        [
            'name.required' => 'Nama harus diisi.',
        'name.string' => 'Nama harus berupa teks.',
        'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
        'username.required' => 'Username harus diisi.',
        'username.string' => 'Username harus berupa teks.',
        'username.max' => 'Username tidak boleh lebih dari :max karakter.',
        'email.required' => 'Email harus diisi.',
        'email.string' => 'Email harus berupa teks.',
        'email.email' => 'Email harus berupa alamat email yang valid.',
        'email.max' => 'Email tidak boleh lebih dari :max karakter.',
        'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        'password.required' => 'Password harus diisi.',
        'password.string' => 'Password harus berupa teks.',
        'password.min' => 'Password harus memiliki minimal :min karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'terms.required' => 'Syarat dan Ketentuan harus diterima.',
        'terms.accepted' => 'Syarat dan Ketentuan harus diterima.',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);


        //  // Atur redirect setelah registrasi ke halaman yang diinginkan
        //  $redirect = '/dashboardCustomer';
        //  $url = URL::to($redirect);

        //  return Redirect::to($url);

    }

}
