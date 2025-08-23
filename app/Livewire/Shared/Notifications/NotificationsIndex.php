<?php

namespace App\Livewire\Shared\Notifications;

use Livewire\Component;
use Livewire\WithPagination;

class NotificationsIndex extends Component
{
    use WithPagination;

    public $filter = 'all'; // all, unread, read
    
    public function markAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
            $this->dispatch('notification-read');
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        $this->dispatch('all-notifications-read');
        session()->flash('success', 'All notifications marked as read.');
    }

    public function deleteNotification($notificationId)
    {
        $notification = auth()->user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->delete();
            $this->dispatch('notification-deleted');
            session()->flash('success', 'Notification deleted successfully.');
        }
    }

    public function deleteAllRead()
    {
        auth()->user()->readNotifications()->delete();
        $this->dispatch('read-notifications-deleted');
        session()->flash('success', 'All read notifications deleted successfully.');
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function render()
    {
        $query = auth()->user()->notifications();

        if ($this->filter === 'unread') {
            $query->whereNull('read_at');
        } elseif ($this->filter === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(15);

        $unreadCount = auth()->user()->unreadNotifications->count();
        $readCount = auth()->user()->readNotifications->count();
        $totalCount = auth()->user()->notifications->count();

        return view('livewire.shared.notifications.notifications-index', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'readCount' => $readCount,
            'totalCount' => $totalCount,
        ]);
    }
}
