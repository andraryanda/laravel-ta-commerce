<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Models\TransactionWifi;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionWifiItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.dashboard.report.index');
    }

    // Export Users
    public function exportUsers()
    {
        $users = DB::table('users')->select('id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token', 'current_team_id', 'created_at', 'updated_at')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=all_users_' . date('d-m-Y') . '.csv',
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token', 'current_team_id', 'created_at', 'updated_at']);

            foreach ($users as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email, $user->username, $user->phone, $user->roles, $user->email_verified_at, $user->password, $user->two_factor_secret, $user->two_factor_recovery_codes, $user->remember_token, $user->current_team_id, $user->created_at, $user->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportCustomUsers(Request $request)
    {
        // Get start_date and end_date from request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $users = DB::table('users')->select('id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token', 'current_team_id', 'created_at', 'updated_at')->get();

        // Set the CSV headers and filename based on current date
        $filename = 'all_users_' . date('d-m-Y') . '.csv';
        if (!empty($start_date) && !empty($end_date)) {
            // If start_date and end_date are provided, update the filename accordingly
            $filename = 'users_' . $start_date . '_to_' . $end_date . '.csv';
        }
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token', 'current_team_id', 'created_at', 'updated_at']);

            foreach ($users as $user) {
                fputcsv($file, [$user->id, $user->name, $user->email, $user->username, $user->phone, $user->roles, $user->email_verified_at, $user->password, $user->two_factor_secret, $user->two_factor_recovery_codes, $user->remember_token, $user->current_team_id, $user->created_at, $user->updated_at]);
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

    public function exportCustomRoleUser(Request $request)
    {
        // Get start_date and end_date from request
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Get users with role USER within specified date range
        $userRoleUsers = User::where('roles', 'USER')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        // Set the CSV headers and filename based on start_date and end_date
        $filename = 'user_role_users_' . $start_date . '_to_' . $end_date . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
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

    public function exportCustomRoleAdmin(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Get users with role ADMIN
        $userRoleAdmins = User::where('roles', 'ADMIN')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        // Set the CSV headers and filename
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=user_role_admins_' . $start_date . '_to_' . $end_date . '.csv',
        ];

        // Define the CSV callback function
        $callback = function () use ($userRoleAdmins) {
            $file = fopen('php://output', 'w');

            // Set the CSV header row
            fputcsv($file, [
                'id', 'name', 'email', 'username', 'phone', 'roles', 'email_verified_at', 'password', 'two_factor_secret',
                'two_factor_recovery_codes', 'two_factor_confirmed_at', 'remember_token', 'current_team_id',
                'profile_photo_url', 'created_at', 'updated_at'
            ]);

            // Add the user data rows
            foreach ($userRoleAdmins as $user) {
                fputcsv($file, [
                    $user->id, $user->name, $user->email, $user->username, $user->phone, $user->roles,
                    $user->email_verified_at, $user->password, $user->two_factor_secret, $user->two_factor_recovery_codes,
                    $user->two_factor_confirmed_at, $user->remember_token, $user->current_team_id,
                    $user->profile_photo_url, $user->created_at, $user->updated_at
                ]);
            }

            fclose($file);
        };

        // Return the CSV file as a StreamedResponse
        return new StreamedResponse($callback, 200, $headers);
    }


    // Export Category
    public function exportProductCategories()
    {
        $productCategories = DB::table('product_categories')
            ->select('id', 'name', 'deleted_at', 'created_at', 'updated_at')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=product_categories_' . date('d-m-Y') . '.csv',
        ];

        $callback = function () use ($productCategories) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($productCategories as $productCategory) {
                fputcsv($file, [$productCategory->id, $productCategory->name, $productCategory->deleted_at, $productCategory->created_at, $productCategory->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportCustomProductCategories(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $productCategories = DB::table('product_categories')
            ->select('id', 'name', 'start_date', 'end_date', 'deleted_at', 'created_at', 'updated_at')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=product_categories_' . $start_date . '_to_' . $end_date . '.csv',
        ];

        $callback = function () use ($productCategories) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Start Date', 'End Date', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($productCategories as $productCategory) {
                fputcsv($file, [
                    $productCategory->id,
                    $productCategory->name,
                    $productCategory->start_date,
                    $productCategory->end_date,
                    $productCategory->deleted_at,
                    $productCategory->created_at,
                    $productCategory->updated_at
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }


    // Export Product
    public function exportProducts(Request $request)
    {
        $products = Product::with('galleries')->with('category')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=products_' . date('d-m-Y') . '.csv',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Price', 'Description', 'Tags', 'Category ID', 'Category', 'Deleted At', 'Created At', 'Updated At', 'Image URL']);

            foreach ($products as $product) {
                $galleryUrls = '';
                // if ($product->galleries->count() > 0) {
                //     foreach ($product->galleries as $gallery) {
                //         // $galleryUrls .= Storage::url($gallery->url) . "\n";
                //         $galleryUrls .= $gallery->url.' || ';
                //     }
                // }
                if ($product->galleries->count() > 0) {
                    foreach ($product->galleries as $key => $gallery) {
                        $galleryUrls .= $gallery->url;
                        if ($key < $product->galleries->count() - 1) {
                            $galleryUrls .= ' || ';
                        }
                    }
                }
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->description,
                    $product->tags,
                    $product->categories_id,
                    $product->category->name,
                    $product->deleted_at,
                    $product->created_at,
                    $product->updated_at,
                    $galleryUrls,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportCustomProducts(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $products = Product::with('galleries')->with('category')
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=products_' . $start_date . '_to_' . $end_date . '.csv',
        ];

        $callback = function () use ($products) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Price', 'Description', 'Tags', 'Category ID', 'Category', 'Deleted At', 'Created At', 'Updated At', 'Image URL']);

            foreach ($products as $product) {
                $galleryUrls = '';
                if ($product->galleries->count() > 0) {
                    foreach ($product->galleries as $key => $gallery) {
                        $galleryUrls .= $gallery->url;
                        if ($key < $product->galleries->count() - 1) {
                            $galleryUrls .= ' || ';
                        }
                    }
                }
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->price,
                    $product->description,
                    $product->tags,
                    $product->categories_id,
                    $product->category->name,
                    $product->deleted_at,
                    $product->created_at,
                    $product->updated_at,
                    $galleryUrls,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }


    // Export Transaction
    // Export Transaction
    public function exportPDF($encryptedId)
    {
        try {
            $transaction_id = Crypt::decrypt($encryptedId); // Mendekripsi ID transaksi
            $transaction = Transaction::findOrFail($transaction_id);

            // Verifikasi role pengguna
            if (auth()->user()->roles != 'ADMIN' && Auth::user()->roles != 'OWNER' && $transaction->users_id != auth()->user()->id) {
                return redirect()->route('landingPage.index')->with('error', 'Anda tidak memiliki akses untuk ekspor PDF transaksi ini');
            }

            $items = DB::table('transaction_items')
                ->join('products', 'transaction_items.products_id', '=', 'products.id')
                ->select('products.name', 'products.price', 'transaction_items.quantity')
                ->where('transactions_id', $transaction_id)
                ->get();

            $total = 0;
            foreach ($items as $item) {
                $total += $item->price * $item->quantity;
            }

            $pdf = new Dompdf();
            $pdf->loadHtml(view('pages.dashboard.transaction.print', compact('transaction', 'items', 'total')));
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
            $output = $pdf->output();
            $file_name = 'Kwitansi_' . $transaction->user->name . '_' . date('d-m-Y', strtotime($transaction->created_at)) . '.pdf';
            file_put_contents($file_name, $output);
            $pdf->stream($file_name);
        } catch (DecryptException $e) {
            return redirect()->route('landingPage.index')->with('error', 'Terjadi kesalahan dalam menghasilkan PDF transaksi');
        }
    }

    public function exportAllTransactions()
    {
        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=all_transactions_' . date('d-m-Y') . '.csv',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportAllCustomTransactions(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=all_transactions_' . date('d-m-Y', strtotime($startDate)) . '_to_' . date('d-m-Y', strtotime($endDate)) . '.csv',
        ];



        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }


    public function exportTransactionSuccess()
    {
        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->where('transactions.status', '=', 'SUCCESS') // add where condition to filter by status
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            // 'Content-Disposition' => 'attachment; filename=all_transactions.csv',
            'Content-Disposition' => 'attachment; filename=transaction_Success_' . date('d-m-Y') . '.csv',

        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportTransactionCustomSuccess(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->where('transactions.status', '=', 'SUCCESS') // Filter transaksi dengan status 'SUCCESS'
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=success_transactions_' . date('d-m-Y', strtotime($startDate)) . '_to_' . date('d-m-Y', strtotime($endDate)) . '.csv',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }



    public function exportTransactionPending()
    {
        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->where('transactions.status', '=', 'PENDING') // add where condition to filter by status
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            // 'Content-Disposition' => 'attachment; filename=all_transactions.csv',
            'Content-Disposition' => 'attachment; filename=transaction_pending_' . date('d-m-Y') . '.csv',

        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportTransactionCustomPending(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->where('transactions.status', '=', 'PENDING') // Filter transaksi dengan status 'SUCCESS'
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=pending_transactions_' . date('d-m-Y', strtotime($startDate)) . '_to_' . date('d-m-Y', strtotime($endDate)) . '.csv',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportTransactionCancelled()
    {
        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->where('transactions.status', '=', 'CANCELLED') // add where condition to filter by status
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            // 'Content-Disposition' => 'attachment; filename=all_transactions.csv',
            'Content-Disposition' => 'attachment; filename=transaction_cancelled_' . date('d-m-Y') . '.csv',

        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportTransactionCustomCancelled(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $transactions = DB::table('transactions')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transactions_id')
            ->join('users', 'transactions.users_id', '=', 'users.id')
            ->join('products', 'transaction_items.products_id', '=', 'products.id')
            ->select('transactions.id', 'transaction_items.products_id', 'transactions.users_id', 'users.name', 'transactions.address', 'products.name as product_name', 'products.price as product_price', 'transaction_items.quantity', 'transactions.total_price', 'transactions.shipping_price', 'transactions.status', 'transactions.payment', 'transactions.deleted_at', 'transactions.created_at', 'transactions.updated_at')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->where('transactions.status', '=', 'CANCELLED') // Filter transaksi dengan status 'SUCCESS'
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=cancelled_transactions_' . date('d-m-Y', strtotime($startDate)) . '_to_' . date('d-m-Y', strtotime($endDate)) . '.csv',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Transaction ID', 'Product ID', 'User ID', 'User Name', 'Address', 'Product Name', 'Harga Produk', 'Quantity', 'Total Price', 'Shipping Price', 'Status', 'Payment Method', 'Deleted At', 'Created At', 'Updated At']);

            foreach ($transactions as $transaction) {
                fputcsv($file, [$transaction->id, $transaction->products_id, $transaction->users_id,  $transaction->name, $transaction->address, $transaction->product_name, $transaction->product_price, $transaction->quantity, $transaction->total_price, $transaction->shipping_price, $transaction->status, $transaction->payment, $transaction->deleted_at, $transaction->created_at, $transaction->updated_at]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportTransactionWifi()
    {
        $transactions = TransactionWifi::with(['user', 'items', 'wifi_items'])
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=transaction_wifis_' . date('d-m-Y') . '.csv',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Transaction ID',
                'User ID',
                'User Name',
                'Product ID',
                'Total Price Wifi',
                'Status',
                'Expired Wifi',
                'Deleted At',
                'Created At',
                'Updated At',
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    $transaction->users_id,
                    $transaction->user->name,
                    $transaction->products_id,
                    $transaction->total_price_wifi,
                    $transaction->status,
                    $transaction->expired_wifi,
                    $transaction->deleted_at,
                    $transaction->created_at,
                    $transaction->updated_at,
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportTransactionCustomWifi(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $transactions = TransactionWifi::with(['user', 'items', 'wifi_items'])
        ->whereBetween('created_at', [$startDate, $endDate])
        ->orderBy('created_at', 'desc')
        ->get();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename=transaction_wifis_' . date('d-m-Y') . '.csv',
    ];

    $callback = function () use ($transactions) {
        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Transaction ID',
            'User ID',
            'User Name',
            'Product ID',
            'Total Price Wifi',
            'Status',
            'Expired Wifi',
            'Deleted At',
            'Created At',
            'Updated At',
        ]);

        foreach ($transactions as $transaction) {
            fputcsv($file, [
                $transaction->id,
                $transaction->users_id,
                $transaction->user->name,
                $transaction->products_id,
                $transaction->total_price_wifi,
                $transaction->status,
                $transaction->expired_wifi,
                $transaction->deleted_at,
                $transaction->created_at,
                $transaction->updated_at,
            ]);
        }

        fclose($file);
    };

    return new StreamedResponse($callback, 200, $headers);
}

public function exportTransactionWifiItem()
{
    $items = TransactionWifiItem::with(['wifis', 'user', 'product'])
        ->orderBy('created_at', 'desc')
        ->get();

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename=transaction_wifi_items_' . date('d-m-Y') . '.csv',
    ];

    $callback = function () use ($items) {
        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'ID',
            'Incre ID',
            'User ID',
            'Product ID',
            'Transaction Wifi ID',
            'Nama Produk',
            'Harga Produk',
            'Name Customer',
            'Total Harga Wifi',
            'Status Pembayaran',
            'Total Pembayaran Customer',
            'Metode Pembayaran',
            'Bank Pembayaran',
            'Deskripsi',
            'Deleted At',
            'Created At',
            'Updated At',
        ]);

        foreach ($items as $item) {
            fputcsv($file, [
                $item->id,
                $item->incre_id,
                $item->users_id,
                $item->products_id,
                $item->transaction_wifi_id,
                $item->product->name,
                $item->product->price,
                $item->user->name,
                $item->wifis->total_price_wifi,
                $item->payment_status,
                $item->payment_transaction,
                $item->payment_method,
                $item->payment_bank,
                $item->description,
                $item->deleted_at,
                $item->created_at,
                $item->updated_at,
            ]);
        }

        fclose($file);
    };

    return new StreamedResponse($callback, 200, $headers);
}




}
