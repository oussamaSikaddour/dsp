<?php

namespace App\Livewire\Core;

use App\Enum\Core\NotificationFor;
use App\Enum\Core\Web\RoutesNames;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class NotificationsButton extends Component
{
    public int $notificationsCount = 0;

    public function refreshNotifications(): void
    {
        $this->dispatch('refresh-notifications');
    }

    #[Computed()]
    public function notifications(): Collection
    {
        $user = auth()->user();

        $cacheKey = sprintf(
            'notifications_%s_%s',
            $user->id,
            session('store_id', 'none')
        );

        return Cache::remember(
            $cacheKey,
            now()->addMinutes(5),
            function () use ($user) {

                $query = Notification::query();

                switch (true) {

                    // Admin
                    case $user->can('admin-access'):
                        $query->where('active', true)
                            ->where('for_type', NotificationFor::ADMIN->value);
                        break;

                    // Store Manager
                    case $user->can('store-manager-access')
                        && session()->has('store_id')
                        && $user->managerable_id === session('store_id'):

                        $query->where('active', true)
                            ->where('for_type', NotificationFor::STORE_MANAGER->value)
                            ->where('targetable_id', session('store_id'));
                        break;

                    // Regular User
                    default:
                        $query->where('targetable_id', $user->id)
                            ->where('active', true);
                        break;
                }

                return $query
                    ->latest('created_at')
                    ->get();
            }
        );
    }

    public function mount(): void
    {
        $this->notificationsCount = $this->notifications->count();
    }

    protected function clearNotificationsCache(): void
    {
        Cache::forget(
            sprintf(
                'notifications_%s_%s',
                auth()->id(),
                session('store_id', 'none')
            )
        );
    }

    public function manageNotification(Notification $notification)
    {
        $notification->update([
            'active' => false,
        ]);

        $this->clearNotificationsCache();

        // Admin notification
        if (
            $notification->for_type->value === NotificationFor::ADMIN->value
            && $notification->targetable_type === Message::class
        ) {
            return redirect()->route(
                RoutesNames::MESSAGES->value
            );
        }

        // Store Manager notification
        if (
            $notification->for_type->value === NotificationFor::STORE_MANAGER->value
            && $notification->targetable_type === Store::class
        ) {
            $storeId = $notification->targetable_id;

            if (session('store_id') != $storeId) {
                abort(403);
            }

            return redirect()->route(
                RoutesNames::STOCK_MOVEMENTS_ROUTE->value,
                ['store' => $storeId]
            );
        }

        return null;
    }

    public function getNotificationMessageKey(Notification $notification): string
    {
        $parameters = $notification->message_parameters ?? [];

        return match ($notification->targetable_type) {
            Message::class => __(
                'notifications.message.' . $notification->message,
                $parameters
            ),

            User::class => __(
                'notifications.user.' . $notification->message,
                $parameters
            ),

            Store::class => __(
                'notifications.store.' . $notification->message,
                $parameters
            ),

            default => __(
                'notifications.general.' . $notification->message,
                $parameters
            ),
        };
    }

    public function render()
    {
        return view('livewire.core.notifications-button');
    }
}
