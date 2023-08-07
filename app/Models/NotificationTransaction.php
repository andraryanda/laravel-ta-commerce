<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transactions_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactions_id');
    }
}



// public function items()
//     {
//         return $this->hasMany(TransactionItem::class, 'transactions_id', 'id');
//     }

//     public function transaction()
//     {
//         return $this->belongsTo(Transaction::class, 'transactions_id');
//     }
