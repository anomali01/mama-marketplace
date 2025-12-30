<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display notifications page.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'all');
        
        $query = Notification::where('user_id', $user->id)
            ->orderByDesc('created_at');
        
        if ($type !== 'all') {
            $query->where('type', $type);
        }
        
        $notifications = $query->paginate(20);
        
        // Get unread counts by type
        $unreadCounts = [
            'all' => Notification::where('user_id', $user->id)->unread()->count(),
            'chat' => Notification::where('user_id', $user->id)->unread()->ofType('chat')->count(),
            'order' => Notification::where('user_id', $user->id)->unread()->ofType('order')->count(),
            'promo' => Notification::where('user_id', $user->id)->unread()->ofType('promo')->count(),
            'system' => Notification::where('user_id', $user->id)->unread()->ofType('system')->count(),
        ];
        
        return view('notifications.index', compact('notifications', 'type', 'unreadCounts', 'user'));
    }

    /**
     * Get unread notification count (for AJAX).
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();
        
        return response()->json(['count' => $count]);
    }

    /**
     * Get recent notifications (for dropdown).
     */
    public function recent()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(10)
            ->get();
        
        $unreadCount = Notification::where('user_id', Auth::id())
            ->unread()
            ->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        // Check ownership
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $type = $request->get('type');
        
        $query = Notification::where('user_id', Auth::id())
            ->unread();
        
        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }
        
        $query->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca');
    }

    /**
     * Delete a notification.
     */
    public function destroy(Notification $notification)
    {
        // Check ownership
        if ($notification->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $notification->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Clear all notifications of a type.
     */
    public function clearAll(Request $request)
    {
        $type = $request->get('type');
        
        $query = Notification::where('user_id', Auth::id());
        
        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }
        
        $query->delete();
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Notifikasi telah dihapus');
    }
}
