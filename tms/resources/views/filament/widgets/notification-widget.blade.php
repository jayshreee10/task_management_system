<div
    x-data="{
        isOpen: false,
        notifications: @js($this->getNotifications()),
        totalUnread: @js($this->getTotalUnreadCount())
    }"
    class="relative flex gap-2 w-full justify-end"
>
    <button
        @click="isOpen = !isOpen"
        class="relative flex items-center justify-between"
    >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        <p class="text-sm font-semibold text-gray-800 cursor-pointer">
            All Notification
        </p>
        <span
            x-show="totalUnread > 0"
            x-text="totalUnread"
            class="absolute -top-3 -right-2 bg-gray-300 text-gray-300 rounded-full px-2 py-0.5 text-xs"
        ></span>
    </button>

    <!-- Notification Sidebar -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed inset-y-0 right-0 max-w-sm w-full bg-white shadow-xl z-50 p-4 overflow-y-auto"
    >
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl text-black font-bold">Notifications</h2>
            <div class="flex items-center space-x-2">
                <button
                    wire:click="markAllAsRead"
                    @click="totalUnread = 0"
                    class="text-sm text-blue-500 hover:text-blue-700"
                >
                    Mark all as read
                </button>
                <button
                    @click="isOpen = false"
                    class="text-gray-500 hover:text-gray-700"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div>
            <template x-if="notifications.length === 0">
                <div class="text-center text-gray-500 py-4">
                    No new notifications
                </div>
            </template>

            <template x-for="notification in notifications" :key="notification.id">
                <div class="border-b py-3 last:border-b-0 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 mr-2">
                            <p x-text="notification.data.message" class="text-sm font-medium text-gray-800"></p>
                            <small
                                x-text="formatTimeAgo(notification.created_at)"
                                class="text-xs text-gray-500"
                            ></small>
                        </div>
                        <button
                            wire:click="markSingleNotificationAsRead(notification.id)"
                            @click="
                                notifications = notifications.filter(n => n.id !== notification.id);
                                totalUnread--;
                            "
                            class="text-xs text-blue-500 hover:text-blue-700"
                        >
                            Dismiss
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script>
        function formatTimeAgo(date) {
            const diff = new Date() - new Date(date);
            const seconds = Math.floor(diff / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (days > 0) return `${days} day${days > 1 ? 's' : ''} ago`;
            if (hours > 0) return `${hours} hour${hours > 1 ? 's' : ''} ago`;
            if (minutes > 0) return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
            return 'Just now';
        }
    </script>
</div>
