<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'products_id', 'transactions_id', 'quantity',
        'id',
        'incre_id',

    ];

    // public $incrementing = false;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // $model->created_at = time();
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    public static function generateTransactionId()
    {
        do {
            $id = Uuid::uuid4()->getHex();
        } while (self::where('id', $id)->exists());

        return $id;
    }

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

    // public function transaction()
    // {
    //     return $this->belongsTo(Transaction::class);
    // }
}
