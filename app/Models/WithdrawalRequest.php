<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'validator_id',
        'amount',
        'total_sales',
        'validator_fee',
        'seller_bank_name',
        'seller_account_number',
        'seller_account_holder_name',
        'status',
        'note',
        'transfer_proof',
        'transferred_at',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'total_sales' => 'decimal:2',
        'validator_fee' => 'decimal:2',
        'transferred_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the seller who requested the withdrawal
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the validator handling this withdrawal
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}
