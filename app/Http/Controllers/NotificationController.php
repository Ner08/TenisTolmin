<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AppNotification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        AppNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view('notifications.index', compact('notifications'));
    }

    public function markAllRead()
    {
        AppNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back();
    }
}
