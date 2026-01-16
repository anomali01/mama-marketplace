<?php

namespace App\Services;

use App\Models\Balance;
use App\Models\TransactionLog;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BalanceService
{
    /**
     * Add income to seller balance from completed order
     * 
     * @param int $sellerId
     * @param int $orderId
     * @param float $grossAmount
     * @param float $validatorSharePercentage (0-100)
     * @param int|null $validatorId
     * @return array ['seller_amount' => float, 'validator_amount' => float]
     */
    public function addOrderIncome(
        int $sellerId,
        int $orderId,
        float $grossAmount,
        float $validatorSharePercentage = 0,
        ?int $validatorId = null
    ): array {
        DB::beginTransaction();
        
        try {
            // Calculate shares
            $validatorAmount = 0;
            $sellerAmount = $grossAmount;
            
            if ($validatorSharePercentage > 0 && $validatorId) {
                $validatorAmount = ($grossAmount * $validatorSharePercentage) / 100;
                $sellerAmount = $grossAmount - $validatorAmount;
            }
            
            // Update seller balance
            $sellerBalance = Balance::firstOrCreate(
                ['user_id' => $sellerId, 'type' => 'seller'],
                ['amount' => 0, 'pending' => 0]
            );
            
            $oldSellerBalance = $sellerBalance->amount;
            $sellerBalance->increment('amount', $sellerAmount);
            
            // Log seller transaction
            TransactionLog::create([
                'user_id' => $sellerId,
                'type' => 'order_income',
                'amount' => $sellerAmount,
                'balance_before' => $oldSellerBalance,
                'balance_after' => $oldSellerBalance + $sellerAmount,
                'description' => "Pendapatan dari pesanan #$orderId",
                'order_id' => $orderId,
                'status' => 'completed',
            ]);
            
            // Update validator balance if applicable
            if ($validatorAmount > 0 && $validatorId) {
                $validatorBalance = Balance::firstOrCreate(
                    ['user_id' => $validatorId, 'type' => 'validator'],
                    ['amount' => 0, 'pending' => 0]
                );
                
                $oldValidatorBalance = $validatorBalance->amount;
                $validatorBalance->increment('amount', $validatorAmount);
                
                // Log validator transaction
                TransactionLog::create([
                    'user_id' => $validatorId,
                    'type' => 'validator_commission',
                    'amount' => $validatorAmount,
                    'balance_before' => $oldValidatorBalance,
                    'balance_after' => $oldValidatorBalance + $validatorAmount,
                    'description' => "Komisi validator dari pesanan #$orderId ($validatorSharePercentage%)",
                    'order_id' => $orderId,
                    'status' => 'completed',
                ]);
            }
            
            DB::commit();
            
            return [
                'seller_amount' => $sellerAmount,
                'validator_amount' => $validatorAmount,
            ];
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to add order income: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Process withdrawal - deduct balance
     * 
     * @param int $sellerId
     * @param int $withdrawalId
     * @param float $amount
     * @return bool
     * @throws Exception
     */
    public function processWithdrawal(int $sellerId, int $withdrawalId, float $amount): bool
    {
        DB::beginTransaction();
        
        try {
            $balance = Balance::where('user_id', $sellerId)
                ->where('type', 'seller')
                ->first();
            
            if (!$balance) {
                throw new Exception('Balance tidak ditemukan');
            }
            
            if ($balance->amount < $amount) {
                throw new Exception('Saldo tidak mencukupi. Saldo Anda: Rp' . number_format($balance->amount, 0, ',', '.'));
            }
            
            $oldBalance = $balance->amount;
            $balance->decrement('amount', $amount);
            
            // Log transaction
            TransactionLog::create([
                'user_id' => $sellerId,
                'type' => 'withdrawal',
                'amount' => -$amount, // Negative for withdrawal
                'balance_before' => $oldBalance,
                'balance_after' => $oldBalance - $amount,
                'description' => "Penarikan saldo #$withdrawalId",
                'withdrawal_id' => $withdrawalId,
                'status' => 'completed',
            ]);
            
            DB::commit();
            return true;
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to process withdrawal: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Refund order - add balance back to buyer or restore seller balance
     * 
     * @param int $userId
     * @param int $orderId
     * @param float $amount
     * @param string $reason
     * @return bool
     */
    public function refundOrder(int $userId, int $orderId, float $amount, string $reason = 'Pembatalan pesanan'): bool
    {
        DB::beginTransaction();
        
        try {
            $balance = Balance::firstOrCreate(
                ['user_id' => $userId, 'type' => 'seller'],
                ['amount' => 0, 'pending' => 0]
            );
            
            $oldBalance = $balance->amount;
            $balance->increment('amount', $amount);
            
            TransactionLog::create([
                'user_id' => $userId,
                'type' => 'refund',
                'amount' => $amount,
                'balance_before' => $oldBalance,
                'balance_after' => $oldBalance + $amount,
                'description' => "$reason - Pesanan #$orderId",
                'order_id' => $orderId,
                'status' => 'completed',
            ]);
            
            DB::commit();
            return true;
            
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to refund order: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get user balance
     * 
     * @param int $userId
     * @param string $type ('seller' or 'validator')
     * @return float
     */
    public function getBalance(int $userId, string $type = 'seller'): float
    {
        $balance = Balance::where('user_id', $userId)
            ->where('type', $type)
            ->first();
        
        return $balance ? $balance->amount : 0;
    }
    
    /**
     * Check if user has sufficient balance
     * 
     * @param int $userId
     * @param float $amount
     * @param string $type
     * @return bool
     */
    public function hasSufficientBalance(int $userId, float $amount, string $type = 'seller'): bool
    {
        return $this->getBalance($userId, $type) >= $amount;
    }
}
