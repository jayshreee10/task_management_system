<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Facades\FilamentIcon;


class UserNotificationsWidget extends Widget
{
    protected static string $view = 'filament.widgets.notification-widget';
    protected static ?int $sort = 1;


    public function getNotifications()
    {
        return Auth::user()->unreadNotifications()
            ->latest()
            ->limit(10)
            ->get();
    }

    public function getTotalUnreadCount()
    {
        return Auth::user()->unreadNotifications()->count();
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);
    }

    public function markSingleNotificationAsRead($notificationId)
    {
        $notification = Auth::user()->unreadNotifications()
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }
    }
}
