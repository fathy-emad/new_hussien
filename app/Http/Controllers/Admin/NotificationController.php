<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $admin = $request->user('admin');

        $notifications = $admin->notifications()->latest()->limit(20)->get()->map(function ($notification) {
            $data = $notification->data;

            return [
                'id' => $notification->id,
                'title' => $data['title'] ?? '',
                'message' => $data['message'] ?? '',
                'url' => $data['url'] ?? route('admin.dashboard'),
                'kind' => $data['kind'] ?? '',
                'read_at' => $notification->read_at?->toIso8601String(),
                'created_at' => $notification->created_at?->diffForHumans(),
            ];
        });

        return response()->json([
            'unread' => $admin->unreadNotifications()->count(),
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $notification = $request->user('admin')->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        return response()->json(['ok' => true]);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user('admin')->unreadNotifications->markAsRead();

        return response()->json(['ok' => true]);
    }
}
