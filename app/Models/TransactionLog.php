<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'withdrawal_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'status',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    /**
     * Get the order associated with this transaction
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user associated with this transaction
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the withdrawal request associated with this transaction
     */
    public function withdrawalRequest()
    {
        return $this->belongsTo(WithdrawalRequest::class, 'withdrawal_id');
    }
}
