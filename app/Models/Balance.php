<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'pending',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'pending' => 'decimal:2',
    ];

    /**
     * Get the user that owns the balance.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get available balance (amount - pending)
     */
    public function getAvailableAttribute()
    {
        return $this->amount - $this->pending;
    }
}
