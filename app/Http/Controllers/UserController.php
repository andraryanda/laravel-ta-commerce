<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Imports\UserAllImport;
use App\Imports\UserAdminImport;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Imports\UserCustomerImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Encryption\DecryptException;
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

        $total_user = User::count();
        $total_user_admin = User::where('roles', '=', 'ADMIN')->count();
        $total_user_customer = User::where('roles', '=', 'USER')->count();

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
                    $encryptedId = Crypt::encrypt($item->id);
                    return '
                    <div class="flex justify-start items-center space-x-3.5">
                    <button type="button" title="Edit"
                    class="flex flex-col edit-button shadow-sm items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                    data-id="' . $encryptedId . '">
                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="delete" loading="lazy" width="20" />
                    <p class="mt-1 text-xs">Edit</p>
                </button>
                    <button type="button" title="Delete"
                            class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $encryptedId . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Delete</p>
                        </button>
                </div>
                ';
                })
                ->rawColumns(['roles', 'action'])
                ->make();
        }

        return view('pages.dashboard.user.index', compact(
            'total_user',
            'total_user_admin',
            'total_user_customer',
        ));
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
                    $encryptedId = Crypt::encrypt($item->id);
                    return '
                    <div class="flex justify-start items-center space-x-3.5">
                    <button type="button" title="Edit"
                    class="flex flex-col edit-button shadow-sm items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                    data-id="' . $encryptedId . '">
                    <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="delete" loading="lazy" width="20" />
                    <p class="mt-1 text-xs">Edit</p>
                </button>
                    <button type="button" title="Delete"
                            class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $encryptedId . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Delete</p>
                        </button>
                </div>
                ';
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
                    $encryptedId = Crypt::encrypt($item->id);
                    return '
                    <div class="flex justify-start items-center space-x-3.5">
                    <button type="button" title="Edit"
                            class="flex flex-col edit-button shadow-sm items-center justify-center w-20 h-12 border border-yellow-500 bg-yellow-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-yellow-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $encryptedId . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/edit.png') . '" alt="delete" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Edit</p>
                        </button>
                    <button type="button" title="Delete"
                            class="flex flex-col delete-button shadow-sm items-center justify-center w-20 h-12 border border-red-500 bg-red-400 text-white rounded-md mx-2 my-2 transition duration-500 ease select-none hover:bg-red-500 focus:outline-none focus:shadow-outline"
                            data-id="' . $encryptedId . '">
                            <img class="object-cover w-6 h-6 rounded-full" src="' . asset('icon/delete.png') . '" alt="delete" loading="lazy" width="20" />
                            <p class="mt-1 text-xs">Delete</p>
                        </button>
                </div>
                ';
                })
                ->rawColumns(['roles', 'action'])
                ->make();
        }

        return view('pages.dashboard.user.index_admin');
    }


    public function importUserAll()
    {
        try {
            $file = request()->file('file');

            // Validasi tipe file
            $allowedTypes = ['xlsx', 'csv'];
            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, $allowedTypes)) {
                throw new \Exception('File type not allowed, File must be type .XLSX & .CSV');
            }

            Excel::import(new UserAllImport, $file);
            return redirect()->back()->withSuccess('Import successful!');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with(compact('errorMessage'))->withError($e->getMessage());
        }
    }

    public function importUserAdmin()
    {
        try {
            $file = request()->file('file');

            // Validasi tipe file
            $allowedTypes = ['xlsx', 'csv'];
            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, $allowedTypes)) {
                throw new \Exception('File type not allowed, File must be type .XLSX & .CSV');
            }

            Excel::import(new UserAdminImport, $file);
            return redirect()->back()->withSuccess('Import successful!');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with(compact('errorMessage'))->withError($e->getMessage());
        }
    }

    public function importUserCustomer()
    {
        try {
            $file = request()->file('file');

            // Validasi tipe file
            $allowedTypes = ['xlsx', 'csv'];
            $fileExtension = $file->getClientOriginalExtension();
            if (!in_array($fileExtension, $allowedTypes)) {
                throw new \Exception('File type not allowed, File must be type .XLSX & .CSV');
            }

            Excel::import(new UserCustomerImport, $file);
            return redirect()->back()->withSuccess('Import successful!');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            return redirect()->back()->with(compact('errorMessage'))->withError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.user.create');
    }

    public function createUserAdmin()
    {
        return view('pages.dashboard.user.createUserAdmin');
    }

    public function createUserCustomer()
    {
        return view('pages.dashboard.user.createUserCustomer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->username = $validatedData['username'];
        $user->password = Hash::make('password');
        $user->roles = $validatedData['roles'];

        $user->save();

        // return redirect()->route('dashboard.user.index')->withSuccess('User berhasil ditambahkan!');
        if ($user->roles == 'ADMIN') {
            return redirect()->route('dashboard.user.indexUserAdmin')->withSuccess('User berhasil ditambahkan!');
        } elseif ($user->roles == 'USER') {
            return redirect()->route('dashboard.user.indexUserCustomer')->withSuccess('User berhasil ditambahkan!');
        } else {
            return redirect()->route('dashboard.index')->withSuccess('User berhasil ditambahkan!');
        }
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
    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $user = User::find($id);

            if (!$user) {
                // Lakukan penanganan jika pengguna tidak ditemukan
                abort(404);
            }

            return view('pages.dashboard.user.edit', [
                'item' => $user
            ]);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Lakukan penanganan jika terjadi kesalahan dalam dekripsi
            abort(400);
        }
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

        return redirect()->route('dashboard.user.index')->withSuccess('User berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            $user = User::find($id);

            if (!$user) {
                // Lakukan penanganan jika user tidak ditemukan
                abort(404);
            }

            $user->delete();

            return redirect()->route('dashboard.user.index')->with('success', 'User telah dihapus.');
        } catch (DecryptException $e) {
            // Lakukan penanganan jika terjadi kesalahan dekripsi
            abort(404);
        }
    }
}
