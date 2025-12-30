<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Menampilkan daftar chat conversations
     */
    public function index()
    {
        $userId = Auth::id();
        $user = Auth::user();
        
        // Ambil semua user yang pernah chat dengan kita (baik sebagai sender atau receiver)
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($message) use ($userId) {
                // Get the other user in conversation
                return $message->sender_id == $userId ? $message->receiver_id : $message->sender_id;
            })
            ->unique()
            ->values()
            ->toArray();
        
        // Juga ambil penjual dari order yang pernah dibeli (untuk memulai chat baru)
        $sellerIds = Order::where('buyer_id', $userId)
            ->with('items.product')
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product.seller_id')
            ->unique()
            ->filter()
            ->toArray();
        
        // Jika user adalah validator, tambahkan semua seller yang punya produk
        if ($user->role === 'validator') {
            $allSellerIds = User::where('role', 'mahasiswa')
                ->whereHas('products')
                ->pluck('id')
                ->toArray();
            $sellerIds = array_merge($sellerIds, $allSellerIds);
        }
        
        // Merge dan unique
        $allUserIds = collect(array_merge($conversations, $sellerIds))->unique()->filter()->values();
        
        // Ambil data user
        $chatUsers = User::whereIn('id', $allUserIds)
            ->where('id', '!=', $userId)
            ->get()
            ->map(function ($chatUser) use ($userId) {
                // Ambil pesan terakhir
                $lastMessage = Message::where(function ($q) use ($userId, $chatUser) {
                    $q->where('sender_id', $userId)->where('receiver_id', $chatUser->id);
                })->orWhere(function ($q) use ($userId, $chatUser) {
                    $q->where('sender_id', $chatUser->id)->where('receiver_id', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->first();
                
                // Hitung unread messages
                $unreadCount = Message::where('sender_id', $chatUser->id)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count();
                
                $chatUser->last_message = $lastMessage;
                $chatUser->unread_count = $unreadCount;
                
                return $chatUser;
            })
            ->sortByDesc(function ($chatUser) {
                return $chatUser->last_message ? $chatUser->last_message->created_at : now()->subYears(10);
            });
        
        // Untuk validator, pisahkan seller yang belum pernah di-chat
        $availableSellers = collect([]);
        if ($user->role === 'validator') {
            $chattedUserIds = $chatUsers->pluck('id')->toArray();
            $availableSellers = User::where('role', 'mahasiswa')
                ->whereHas('products')
                ->whereNotIn('id', $chattedUserIds)
                ->where('id', '!=', $userId)
                ->withCount('products')
                ->get();
        }
        
        return view('messages.index', compact('chatUsers', 'availableSellers'));
    }

    /**
     * Menampilkan halaman chat dengan user tertentu
     */
    public function show(User $seller)
    {
        $userId = Auth::id();
        
        // Mark messages as read
        Message::where('sender_id', $seller->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Get messages between users
        $messages = Message::where(function ($q) use ($userId, $seller) {
            $q->where('sender_id', $userId)->where('receiver_id', $seller->id);
        })->orWhere(function ($q) use ($userId, $seller) {
            $q->where('sender_id', $seller->id)->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();
        
        // Get products purchased from this seller (if any)
        $purchasedProducts = Order::where('buyer_id', $userId)
            ->whereHas('items.product', function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            })
            ->with(['items.product' => function ($query) use ($seller) {
                $query->where('seller_id', $seller->id);
            }])
            ->get()
            ->pluck('items')
            ->flatten()
            ->pluck('product')
            ->unique('id');
        
        return view('messages.show', compact('seller', 'messages', 'purchasedProducts'));
    }

    /**
     * Kirim pesan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required_without:attachment|nullable|string|max:2000',
            'attachment' => 'nullable|file|max:10240', // max 10MB
        ]);

        $userId = Auth::id();
        
        $data = [
            'sender_id' => $userId,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ];

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat-attachments', 'public');
            $data['attachment'] = $path;
            $data['attachment_name'] = $file->getClientOriginalName();
            
            // Determine type
            $mimeType = $file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $data['attachment_type'] = 'image';
            } else {
                $data['attachment_type'] = 'file';
            }
        }

        $message = Message::create($data);

        // Create notification for receiver
        $sender = User::find($userId);
        \App\Models\Notification::createChatNotification(
            $request->receiver_id,
            $sender->name,
            $request->message ?? 'Mengirim file',
            $userId
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back();
    }

    /**
     * Get new messages (for polling/realtime)
     */
    public function getMessages(User $seller, Request $request)
    {
        $userId = Auth::id();
        $lastId = $request->get('last_id', 0);
        
        // Mark as read
        Message::where('sender_id', $seller->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Get new messages
        $messages = Message::where(function ($q) use ($userId, $seller) {
            $q->where('sender_id', $userId)->where('receiver_id', $seller->id);
        })->orWhere(function ($q) use ($userId, $seller) {
            $q->where('sender_id', $seller->id)->where('receiver_id', $userId);
        })
        ->where('id', '>', $lastId)
        ->orderBy('created_at', 'asc')
        ->get();
        
        return response()->json([
            'messages' => $messages->load('sender'),
        ]);
    }

    /**
     * Get unread count
     */
    public function unreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
        
        return response()->json(['count' => $count]);
    }
}
