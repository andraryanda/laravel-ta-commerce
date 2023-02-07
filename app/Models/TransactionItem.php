<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'products_id', 'transactions_id', 'quantity'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id', 'products_id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'id', 'products_id');
    }

    // public function galleries()
    // {
    //     return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    // }

}
