<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'image',
        'action_url',
        'data',
        'related_id',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Notification types
    const TYPE_CHAT = 'chat';
    const TYPE_ORDER = 'order';
    const TYPE_PROMO = 'promo';
    const TYPE_SYSTEM = 'system';
    const TYPE_PRODUCT = 'product';

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Create a chat notification.
     */
    public static function createChatNotification($userId, $senderName, $message, $senderId)
    {
        return self::create([
            'user_id' => $userId,
            'type' => self::TYPE_CHAT,
            'title' => 'Pesan baru dari ' . $senderName,
            'message' => \Str::limit($message, 100),
            'icon' => '💬',
            'action_url' => '/messages/' . $senderId,
            'data' => ['sender_id' => $senderId],
        ]);
    }

    /**
     * Create an order notification.
     */
    public static function createOrderNotification($userId, $title, $message, $orderId, $type = 'new')
    {
        $icons = [
            'new' => '🛒',
            'paid' => '💰',
            'shipped' => '📦',
            'completed' => '✅',
            'cancelled' => '❌',
        ];

        return self::create([
            'user_id' => $userId,
            'type' => self::TYPE_ORDER,
            'title' => $title,
            'message' => $message,
            'icon' => $icons[$type] ?? '🛒',
            'action_url' => '/orders/' . $orderId,
            'data' => ['order_id' => $orderId, 'order_type' => $type],
        ]);
    }

    /**
     * Create a promo notification.
     */
    public static function createPromoNotification($userId, $title, $message, $image = null, $actionUrl = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => self::TYPE_PROMO,
            'title' => $title,
            'message' => $message,
            'icon' => '🎉',
            'image' => $image,
            'action_url' => $actionUrl ?? '/products',
        ]);
    }

    /**
     * Create a system notification.
     */
    public static function createSystemNotification($userId, $title, $message, $actionUrl = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => self::TYPE_SYSTEM,
            'title' => $title,
            'message' => $message,
            'icon' => '🔔',
            'action_url' => $actionUrl,
        ]);
    }

    /**
     * Create a product notification.
     */
    public static function createProductNotification($userId, $title, $message, $productId, $image = null)
    {
        return self::create([
            'user_id' => $userId,
            'type' => self::TYPE_PRODUCT,
            'title' => $title,
            'message' => $message,
            'icon' => '📱',
            'image' => $image,
            'action_url' => '/products/' . $productId,
            'data' => ['product_id' => $productId],
        ]);
    }
}
