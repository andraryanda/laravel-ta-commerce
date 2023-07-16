<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password;

class UserController extends Controller
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function fetch(Request $request)
    {
        return ResponseFormatter::success($request->user(), 'Data profile user berhasil diambil');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
                // 'roles' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    // public function register(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'name' => ['required', 'string', 'max:255'],
    //             'username' => ['required', 'string', 'max:255', 'unique:users'],
    //             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //             'password' => ['required', 'string', new Password],
    //             'phone' => ['required'],
    //             'alamat' => ['required']
    //         ]);

    //         User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'username' => $request->username,
    //             'password' => Hash::make($request->password),
    //             'phone' => $request->phone,
    //             'alamat' => $request->alamat,
    //         ])->markEmailAsVerified();

    //         $user = User::where('email', $request->email)->first();

    //         $tokenResult = $user->createToken('authToken')->plainTextToken;

    //         return ResponseFormatter::success([
    //             'access_token' => $tokenResult,
    //             'token_type' => 'Bearer',
    //             'user' => $user
    //         ], 'User Registered');
    //     } catch (Exception $error) {
    //         return ResponseFormatter::error([
    //             'message' => 'Something went wrong',
    //             'error' => $error,
    //         ], 'Authentication Failed', 500);
    //     }
    // }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => ['required', 'string', 'max:255'],
                    'username' => ['required', 'string', 'max:255', 'unique:users'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    // 'password' => ['required', 'string', new Password],
                    'password' => ['required'],
                    'phone' => ['required'],
                    'alamat' => ['required']
                ],
                [
                    'name.required' => 'Nama harus diisi',
                    'username.required' => 'Username harus diisi',
                    'email.required' => 'Email harus diisi',
                    'password.required' => 'Password harus diisi',
                    'phone.required' => 'Nomor telepon harus diisi',
                    'alamat.required' => 'Alamat harus diisi'

                ]
            );

            if ($validator->fails()) {
                return ResponseFormatter::error([
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 'Validation Failed', 422);
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'alamat' => $request->alamat,
            ])->markEmailAsVerified();

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'User Registered');
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error,
            ], 'Authentication Failed', 500);
        }
    }


    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated');
    }
}
