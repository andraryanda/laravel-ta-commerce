<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TransactionWifiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return false;
        return Auth::check();

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'users_id' => 'required',
            'transactions_id' => 'required',
            'products_id' => 'required|exists:products,id',
            'transaction_wifi_id' => 'nullable',
            'total_price_wifi' => 'required|numeric|not_in:0',
            'status' => 'required|in:ACTIVE,INACTIVE',
            'expired_wifi' => 'required',
            // 'payment_status' => 'required|in:PAID,UNPAID',
            // 'payment_method' => 'required|in:BANK TRANSFER,MANUAL',
            // 'payment_bank' => 'nullable',
            // 'payment_bank' => 'required_if:payment_method,BANK TRANSFER',
            // 'payment_transaction' => 'required|numeric|not_in:0',
            // 'description' => 'nullable',
        ];
    }


    public function messages(){
    return [
        'users_id.required' => 'Field Pengguna harus diisi.',
        'products_id.required' => 'Field Produk harus diisi.',
        'transactions_id.required' => 'Field ID Transaksi Pengguna harus diisi.',
        'products_id.exists' => 'Produk yang dipilih tidak valid.',
        'transaction_wifi_id.required' => 'Field ID Transaksi Wifi harus diisi.',
        'total_price_wifi.required' => 'Kolom total harga wajib diisi.',
        'total_price_wifi.numeric' => 'Total harga harus berupa angka.',
        'total_price_wifi.not_in' => 'Total harga harus lebih dari 0.',
        'status.required' => 'Field Status Wifi harus diisi.',
        'status.in' => 'Status Wifi harus berupa ACTIVE atau INACTIVE.',
        'expired_wifi.required' => 'Field Tanggal Kadaluarsa Wifi harus diisi.',
        // 'payment_status.required' => 'Field Status Pembayaran harus diisi.',
        // 'payment_status.in' => 'Status Pembayaran harus berupa PAID atau UNPAID.',
        // 'payment_method.required' => 'Field Metode Pembayaran harus diisi.',
        // 'payment_method.in' => 'Metode Pembayaran harus berupa BANK TRANSFER atau MANUAL.',
        // 'payment_bank.required_if' => 'Field Payment Bank harus diisi jika metode pembayaran adalah Transfer Bank.',
        // 'payment_transaction.required' => 'Kolom transaksi pembayaran wajib diisi.',
        // 'payment_transaction.numeric' => 'Transaksi pembayaran harus berupa angka.',
        // 'payment_transaction.not_in' => 'Transaksi pembayaran harus lebih dari 0.',
    ];
}

}
