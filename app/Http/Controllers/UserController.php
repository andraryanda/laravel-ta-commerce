<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Imports\UserAllImport;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = User::query();

            return DataTables::of($query)
                ->addColumn('roles', function ($item) {
                    if ($item->roles == 'USER') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->roles == 'ADMIN') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->roles == 'OWNER') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } else {
                        return '
                            <td class="px-4 py-3 text-xs">
                                Not Found!
                            </td>
                        ';
                    }
                })
                ->addColumn('action', function ($item) {
                    return '
                        <a title="Edit" class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.user.edit', $item->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.user.destroy', $item->id) . '" method="POST">
                        <button title="Hapus" class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        <i class="fa fa-trash"></i> Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->rawColumns(['roles', 'action'])
                ->make();
        }

        return view('pages.dashboard.user.index');
    }

    public function indexUserCustomer()
    {
        if (request()->ajax()) {
            $query = User::query()->where('roles', '=', 'USER');

            return DataTables::of($query)
                ->addColumn('roles', function ($item) {
                    if ($item->roles == 'USER') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->roles == 'ADMIN') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->roles == 'OWNER') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } else {
                        return '
                            <td class="px-4 py-3 text-xs">
                                Not Found!
                            </td>
                        ';
                    }
                })
                ->addColumn('action', function ($item) {
                    return '
                        <a title="Edit" class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.user.edit', $item->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.user.destroy', $item->id) . '" method="POST">
                        <button title="Hapus" class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        <i class="fa fa-trash"></i> Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->rawColumns(['roles', 'action'])
                ->make();
        }

        return view('pages.dashboard.user.index_customer');
    }

    public function indexUserAdmin()
    {
        if (request()->ajax()) {
            $query = User::query()->where('roles', '=', 'ADMIN');

            return DataTables::of($query)
                ->addColumn('roles', function ($item) {
                    if ($item->roles == 'USER') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->roles == 'ADMIN') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-700 dark:text-yellow-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } elseif ($item->roles == 'OWNER') {
                        return '
                            <td class="px-4 py-3 text-xs">
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">
                                    ' . $item->roles . '
                                </span>
                            </td>
                        ';
                    } else {
                        return '
                            <td class="px-4 py-3 text-xs">
                                Not Found!
                            </td>
                        ';
                    }
                })
                ->addColumn('action', function ($item) {
                    return '
                        <a title="Edit" class="inline-block border border-yellow-500 bg-yellow-400 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                            href="' . route('dashboard.user.edit', $item->id) . '">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <form class="inline-block" action="' . route('dashboard.user.destroy', $item->id) . '" method="POST">
                        <button title="Hapus" class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        <i class="fa fa-trash"></i> Hapus
                        </button>
                            ' . method_field('delete') . csrf_field() . '
                        </form>';
                })
                ->rawColumns(['roles', 'action'])
                ->make();
        }

        return view('pages.dashboard.user.index_admin');
    }

    public function exportUsers()
    {
        $users = DB::table('users')->select('id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'current_team_id', 'profile_photo_url', 'created_at', 'updated_at')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=all_users_' . date('d-m-Y') . '.csv',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'current_team_id', 'profile_photo_url', 'created_at', 'updated_at']);

            foreach ($users as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email, $user->username, $user->phone, $user->roles, $user->email_verified_at, $user->password, $user->two_factor_secret, $user->two_factor_recovery_codes, $user->two_factor_confirmed_at, $user->remember_token, $user->current_team_id, $user->profile_photo_url, $user->created_at, $user->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportRoleUser()
    {
        // Get users with role USER
        $userRoleUsers = User::where('roles', 'USER')->get();

        // Set the CSV headers and filename
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=user_role_users_' . date('d-m-Y') . '.csv',
        ];

        // Define the CSV callback function
        $callback = function () use ($userRoleUsers) {
            $file = fopen('php://output', 'w');

            // Set the CSV header row
            fputcsv($file, ['id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'current_team_id', 'profile_photo_url', 'created_at', 'updated_at']);

            // Add the user data rows
            foreach ($userRoleUsers as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email, $user->username, $user->phone, $user->roles, $user->email_verified_at, $user->password, $user->two_factor_secret, $user->two_factor_recovery_codes, $user->two_factor_confirmed_at, $user->remember_token, $user->current_team_id, $user->profile_photo_url, $user->created_at, $user->updated_at]);
            }

            fclose($file);
        };

        // Return the CSV file as a StreamedResponse
        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportRoleAdmin()
    {
        // Get users with role USER
        $userRoleUsers = User::where('roles', 'ADMIN')->get();

        // Set the CSV headers and filename
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=user_role_admins_' . date('d-m-Y') . '.csv',
        ];

        // Define the CSV callback function
        $callback = function () use ($userRoleUsers) {
            $file = fopen('php://output', 'w');

            // Set the CSV header row
            fputcsv($file, ['id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'current_team_id', 'profile_photo_url', 'created_at', 'updated_at']);

            // Add the user data rows
            foreach ($userRoleUsers as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email, $user->username, $user->phone, $user->roles, $user->email_verified_at, $user->password, $user->two_factor_secret, $user->two_factor_recovery_codes, $user->two_factor_confirmed_at, $user->remember_token, $user->current_team_id, $user->profile_photo_url, $user->created_at, $user->updated_at]);
            }

            fclose($file);
        };

        // Return the CSV file as a StreamedResponse
        return new StreamedResponse($callback, 200, $headers);
    }

    public function importUserAll(Request $request)
    {
        //melakukan import file
        Excel::import(new UserAllImport, request()->file('file'));
        //jika berhasil kembali ke halaman sebelumnya
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::get();
        return view('pages.dashboard.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('pages.dashboard.user.edit', [
            'item' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $request->all();

        $user->update($data);

        return redirect()->route('dashboard.user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard.user.index');
    }
}
