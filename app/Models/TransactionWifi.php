<?php

namespace App\Models;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionWifi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =
    [
        'id',
        'incre_id',
        'users_id',
        'products_id',
        'transactions_id',
        'total_price_wifi',
        'status',
        'expired_wifi',
    ];


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

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function items()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function wifi_items()
    {
        return $this->hasMany(TransactionWifiItem::class, 'transaction_wifi_id', 'id');
    }
}
