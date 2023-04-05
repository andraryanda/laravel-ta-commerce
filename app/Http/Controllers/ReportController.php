<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
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


    // Export Transaction
    public function exportPDF(Transaction $transaction)
    {
        $transaction_id = $transaction->id;

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
        // file_put_contents('Kwitansi_' . $transaction->user->name . '_' . date('d-m-Y') . '.pdf', $output);
        // $pdf->stream('Kwitansi_' . $transaction->user->name . '_' . date('d-m-Y') . '.pdf');
        $file_name = 'Kwitansi_' . $transaction->user->name . '_' . date('d-m-Y', strtotime($transaction->created_at)) . '.pdf';
        file_put_contents($file_name, $output);
        $pdf->stream($file_name);
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
            // 'Content-Disposition' => 'attachment; filename=all_transactions.csv',
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
