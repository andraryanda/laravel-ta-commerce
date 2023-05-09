<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|integer',
            'categories_id' => 'required|exists:product_categories,id',
            'status_product' => 'required|in:ACTIVE,INACTIVE'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nama produk harus diisi',
            'name.max' => 'Nama produk tidak boleh lebih dari :max karakter',
            'description.required' => 'Deskripsi produk harus diisi',
            'price.required' => 'Harga produk harus diisi',
            'price.integer' => 'Harga produk harus berupa angka',
            'categories_id.required' => 'Kategori produk harus dipilih',
            'categories_id.exists' => 'Kategori produk tidak valid',
            'status_product.required' => 'Status produk harus dipilih',
            'status_product.in' => 'Status produk tidak valid'
        ];
    }
}
