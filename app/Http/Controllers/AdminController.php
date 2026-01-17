<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_validators' => User::where('role', 'validator')->count(),
            'pending_validators' => User::where('role', 'validator')->where('verified', false)->count(),
            'verified_validators' => User::where('role', 'validator')->where('verified', true)->count(),
            'total_sellers' => User::where('role', 'mahasiswa')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display list of validators for approval
     */
    public function validators()
    {
        $pendingValidators = User::where('role', 'validator')
            ->where('verified', false)
            ->with('validatorStudyProgram')
            ->latest()
            ->get();

        $verifiedValidators = User::where('role', 'validator')
            ->where('verified', true)
            ->with('validatorStudyProgram')
            ->latest()
            ->get();

        return view('admin.validators', compact('pendingValidators', 'verifiedValidators'));
    }

    /**
     * Approve validator
     */
    public function approveValidator(User $validator)
    {
        if ($validator->role !== 'validator') {
            return back()->with('error', 'User bukan validator.');
        }

        // Cek apakah sudah ada validator verified untuk prodi ini
        $existingValidator = User::where('role', 'validator')
            ->where('validator_prodi_id', $validator->validator_prodi_id)
            ->where('verified', true)
            ->where('id', '!=', $validator->id)
            ->first();

        if ($existingValidator) {
            return back()->with('error', 'Program studi ini sudah memiliki validator aktif: ' . $existingValidator->name . '. Hanya 1 validator per prodi yang diperbolehkan.');
        }

        $validator->update(['verified' => true]);

        // Send notification to validator
        \App\Models\Notification::create([
            'user_id' => $validator->id,
            'title' => 'Akun Validator Disetujui! 🎉',
            'message' => 'Selamat! Akun validator Anda telah disetujui. Anda sekarang dapat memverifikasi produk dari prodi ' . ($validator->validatorProdi->name ?? '-'),
            'type' => 'system',
            'read' => false,
        ]);

        return back()->with('success', 'Validator "' . $validator->name . '" berhasil diverifikasi!');
    }

    /**
     * Reject validator
     */
    public function rejectValidator(Request $request, User $validator)
    {
        if ($validator->role !== 'validator') {
            return back()->with('error', 'User bukan validator.');
        }

        // Hapus validator yang ditolak
        $name = $validator->name;
        $validator->delete();

        return back()->with('success', 'Validator "' . $name . '" ditolak dan dihapus dari sistem.');
    }
}
