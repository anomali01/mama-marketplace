<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        // Get order counts by status
        $orderCounts = [
            'dikemas' => Order::where('buyer_id', $user->id)->where('status', 'processing')->count(),
            'pengiriman' => Order::where('buyer_id', $user->id)->where('status', 'shipped')->count(),
            'selesai' => Order::where('buyer_id', $user->id)->where('status', 'completed')->count(),
        ];
        
        // Get recommended products (handle case where status column might not exist)
        try {
            $recommendedProducts = Product::with(['category', 'seller'])
                ->where('status', 'verified')
                ->where('seller_id', '!=', $user->id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        } catch (\Exception $e) {
            $recommendedProducts = Product::with(['category', 'seller'])
                ->where('seller_id', '!=', $user->id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }
        
        // Validator statistics
        $validatorStats = [];
        if ($user->role === 'validator') {
            $validatorStats = [
                'pending' => Product::where('status', 'pending_verif')->count(),
                'verified' => Product::where('status', 'verified')->count(),
                'rejected' => Product::where('status', 'rejected')->count(),
            ];
        }
        
        return view('profile.index', [
            'user' => $user,
            'orderCounts' => $orderCounts,
            'recommendedProducts' => $recommendedProducts,
            'validatorStats' => $validatorStats,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's settings form.
     */
    public function settings(Request $request): View
    {
        return view('profile.settings', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile settings.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.settings')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Password saat ini salah.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('profile.settings')->with('success', 'Password berhasil diubah!');
    }
}
