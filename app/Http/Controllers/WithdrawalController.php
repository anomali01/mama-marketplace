<?php

namespace App\Http\Controllers;

use App\Models\WithdrawalRequest;
use App\Models\Order;
use App\Models\TransactionLog;
use App\Models\Balance;
use App\Models\Notification;
use App\Models\User;
use App\Models\StudyProgram;
use App\Services\BalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Show withdrawal page for seller
     */
    public function index()
    {
        $user = Auth::user();

        // Get seller balance dari tabel balances
        $balance = Balance::firstOrCreate(
            ['user_id' => $user->id, 'type' => 'seller'],
            ['amount' => 0, 'pending' => 0]
        );

        // Hitung total yang sudah ditarik (completed)
        $totalWithdrawn = WithdrawalRequest::where('seller_id', $user->id)
            ->where('status', 'completed')
            ->sum('amount');

        // Riwayat withdrawal
        $withdrawals = WithdrawalRequest::where('seller_id', $user->id)
            ->with('validator')
            ->latest()
            ->paginate(10);

        return view('seller.withdrawals.index', compact('balance', 'totalWithdrawn', 'withdrawals'));
    }

    /**
     * Request withdrawal
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'seller_bank_name' => 'required|string|max:100',
            'seller_account_number' => 'required|string|max:50',
            'seller_account_holder_name' => 'required|string|max:150',
            'note' => 'nullable|string|max:500',
        ]);

        // Get seller balance
        $balance = Balance::where('user_id', $user->id)
            ->where('type', 'seller')
            ->first();

        if (!$balance || $request->amount > $balance->available) {
            return back()->with('error', 'Saldo tidak mencukupi. Tersedia: Rp' . number_format($balance->available ?? 0, 0, ',', '.'));
        }

        DB::beginTransaction();
        try {
            // Increment pending balance
            $balance->increment('pending', $request->amount);

            // Hitung fee validator (3%)
            $validatorFee = $request->amount / 0.97 * 0.03;

            // Cari validator dari prodi yang sama
            $studyProgram = StudyProgram::where('name', 'LIKE', '%' . $user->prodi . '%')->first();
            $validator = null;
            if ($studyProgram) {
                $validator = User::where('role', 'validator')
                    ->where('validator_prodi_id', $studyProgram->id)
                    ->first();
            }

            $withdrawal = WithdrawalRequest::create([
                'seller_id' => $user->id,
                'validator_id' => $validator?->id,
                'amount' => $request->amount,
                'total_sales' => $request->amount / 0.97,
                'validator_fee' => $validatorFee,
                'seller_bank_name' => $request->seller_bank_name,
                'seller_account_number' => $request->seller_account_number,
                'seller_account_holder_name' => $request->seller_account_holder_name,
                'note' => $request->note,
                'status' => 'pending',
            ]);

            // Kirim notifikasi ke validator
            if ($validator) {
                Notification::create([
                    'user_id' => $validator->id,
                    'type' => 'withdrawal_request',
                    'title' => 'Permintaan Penarikan Dana Baru',
                    'message' => $user->name . ' mengajukan penarikan dana sebesar Rp' . number_format($request->amount, 0, ',', '.') . '. Silakan transfer ke rekening penjual.',
                    'related_id' => $withdrawal->id,
                    'is_read' => false,
                ]);
            }

            // Update data rekening seller di profil
            $user->update([
                'seller_bank_name' => $request->seller_bank_name,
                'seller_account_number' => $request->seller_account_number,
                'seller_account_holder_name' => $request->seller_account_holder_name,
            ]);

            DB::commit();
            return redirect()->route('seller.withdrawals')->with('success', 'Permintaan penarikan berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Withdrawal request error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Validator - List withdrawal requests
     */
    public function validatorIndex(Request $request)
    {
        $user = Auth::user();
        $currentStatus = $request->get('status', 'pending');

        // Filter berdasarkan validator_id yang di-assign
        $withdrawals = WithdrawalRequest::with(['seller'])
            ->where('validator_id', $user->id)
            ->where('status', $currentStatus)
            ->latest()
            ->paginate(15);

        // Stats juga filter per validator
        $pendingCount = WithdrawalRequest::where('validator_id', $user->id)
            ->where('status', 'pending')
            ->count();
            
        $processingCount = WithdrawalRequest::where('validator_id', $user->id)
            ->where('status', 'processing')
            ->count();
            
        $transferredCount = WithdrawalRequest::where('validator_id', $user->id)
            ->where('status', 'transferred')
            ->count();

        return view('validator.withdrawals.index', compact('withdrawals', 'pendingCount', 'processingCount', 'transferredCount', 'currentStatus'));
    }

    /**
     * Validator - Show withdrawal detail
     */
    public function show(WithdrawalRequest $withdrawal)
    {
        $withdrawal->load('seller');
        return view('validator.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Validator - Process withdrawal (assign to self)
     */
    public function process(WithdrawalRequest $withdrawal)
    {
        $withdrawal->update([
            'status' => 'processing',
            'validator_id' => Auth::id(),
        ]);

        return back()->with('success', 'Penarikan dana diambil untuk diproses.');
    }

    /**
     * Validator - Upload transfer proof
     */
    public function uploadProof(Request $request, WithdrawalRequest $withdrawal)
    {
        $request->validate([
            'transfer_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('transfer_proof')) {
            $path = $request->file('transfer_proof')->store('transfer-proofs', 'public');
            
            DB::beginTransaction();
            try {
                // ✅ FIX: Deduct balance using BalanceService saat upload proof
                $balanceService = new BalanceService();
                $balanceService->processWithdrawal(
                    sellerId: $withdrawal->seller_id,
                    withdrawalId: $withdrawal->id,
                    amount: $withdrawal->amount
                );
                
                $withdrawal->update([
                    'transfer_proof' => $path,
                    'status' => 'completed', // Langsung completed karena sudah transfer
                    'transferred_at' => now(),
                    'completed_at' => now(),
                ]);
                
                // Also decrement pending
                $balance = Balance::where('user_id', $withdrawal->seller_id)
                    ->where('type', 'seller')
                    ->first();
                if ($balance) {
                    $balance->decrement('pending', $withdrawal->amount);
                }

                // Notify seller
                Notification::create([
                    'user_id' => $withdrawal->seller_id,
                    'type' => 'withdrawal_completed',
                    'title' => 'Penarikan Dana Berhasil',
                    'message' => 'Dana sebesar Rp' . number_format($withdrawal->amount, 0, ',', '.') . ' telah ditransfer ke rekening Anda.',
                    'related_id' => $withdrawal->id,
                    'is_read' => false,
                ]);
                
                DB::commit();
                return back()->with('success', 'Bukti transfer berhasil diupload dan saldo sudah dikurangi!');
                
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Gagal upload: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'Gagal upload bukti transfer.');
    }

    /**
     * Seller - Confirm withdrawal received
     */
    /**
     * Seller - Confirm withdrawal received (DEPRECATED - now auto-completed)
     * Balance sudah dikurangi saat validator upload proof
     */
    public function confirm(WithdrawalRequest $withdrawal)
    {
        if ($withdrawal->seller_id !== Auth::id()) {
            abort(403);
        }

        // Just mark as completed if not already
        if ($withdrawal->status !== 'completed') {
            $withdrawal->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);
        }

        return back()->with('success', 'Penarikan dana telah dikonfirmasi.');
    }
}
