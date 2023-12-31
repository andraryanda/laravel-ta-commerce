<?php

namespace App\Models;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionWifiItem extends Model
{
    use HasFactory, SoftDeletes;

    protected  $fillable =
    [
        'id',
        'incre_id',
        'users_id',
        'products_id',
        'transaction_wifi_id',
        'payment_status',
        'payment_transaction',
        'payment_method',
        'payment_bank',
        'description',
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

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'id', 'products_id');
    }

    public function wifis()
    {
        return $this->belongsTo(TransactionWifi::class, 'transaction_wifi_id', 'id');
    }

    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'id', 'products_id');
    }
}
