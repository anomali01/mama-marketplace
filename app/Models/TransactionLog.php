<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'validator_id',
        'seller_id',
        'type',
        'amount',
        'validator_fee',
        'seller_amount',
        'status',
        'description',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'validator_fee' => 'decimal:2',
        'seller_amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the order associated with this transaction
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the validator handling this transaction
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }

    /**
     * Get the seller receiving payment
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
