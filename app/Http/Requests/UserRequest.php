<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'password' => Hash::make($this->password),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|max:255',
            // 'roles' => 'required|string|in:USER,ADMIN'
            'roles' => ['required', 'string', function ($attribute, $value, $fail) {
                $roles = ['USER', 'ADMIN'];
                if (!in_array(decrypt($value), $roles)) {
                    return $fail('The ' . $attribute . ' field is invalid.');
                }
            }],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom Nama tidak boleh kosong.',
            'email.required' => 'Kolom Email tidak boleh kosong.',
            'email.email' => 'Harap masukkan alamat email yang valid.',
            'username.required' => 'Kolom Username tidak boleh kosong.',
            'roles.required' => 'Harap pilih peran pengguna.',
            'roles.in' => 'Harap pilih peran pengguna yang valid.',
        ];
    }
}
