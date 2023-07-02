<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id',
        'address',
        'payment',
        'total_price',
        'shipping_price',
        'status',
        'incre_id',
        'snap_token',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class, 'transactions_id', 'id');
    }

    public function wifi_items()
    {
        return $this->hasMany(TransactionWifi::class, 'transactions_id', 'id');
    }
}
