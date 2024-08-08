<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientTransactions extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'description', 'debtor', 'creditor', 'order_id', 'transaction_type_id', 'transaction_status', 'image',
    ];

    // protected $fillable = ['order'];

    public function dateFormatted($filedDate = 'created_at', $showTimes = false)
    {
        $format = 'Y-m-d';
        if ($showTimes) {
            $format = $format.' h:i:s a';
        }

        return $this->$filedDate->format($format);

    }

    public function getOrderAttribute()
    {
        return Order::where('id', $this->order_id)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }
}
