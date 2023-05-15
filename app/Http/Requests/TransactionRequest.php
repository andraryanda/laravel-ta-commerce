<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'users_id' => 'required',
            // 'products_id' => 'required|exists:products,id',
            // 'address' => 'required',
            // 'quantity' => 'required|min:1',
            // 'shipping_price' => 'required',
            // 'total_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED'
        ];
    }

    public function messages()
    {
        return [
            // 'users_id.required' => 'User id harus diisi.',
            // 'products_id.required' => 'Product id harus diisi.',
            // 'products_id.exists' => 'Product tidak ditemukan.',
            // 'address.required' => 'Alamat harus diisi.',
            // 'quantity.required' => 'Jumlah produk harus diisi.',
            // 'quantity.min' => 'Jumlah produk minimal 1.',
            // 'shipping_price.required' => 'Harga pengiriman harus diisi.',
            // 'total_price.required' => 'Total harga harus diisi.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status harus dalam daftar berikut: PENDING, SUCCESS, CANCELLED, FAILED, SHIPPING, SHIPPED.',
        ];
    }
}
