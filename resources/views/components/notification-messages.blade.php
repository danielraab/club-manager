@php
        \App\Facade\NotificationMessage::addNotificationMessage(new \App\NotificationMessage\Item("test",displayedSeconds: 2));
        \App\Facade\NotificationMessage::addNotificationMessage(new \App\NotificationMessage\Item("test message", \App\NotificationMessage\ItemType::SUCCESS, "test title",displayedSeconds: 5));
        \App\Facade\NotificationMessage::addNotificationMessage(new \App\NotificationMessage\Item("test3 a very long message could lead to a mobile problem, therfore i write this longer notifigation message", \App\NotificationMessage\ItemType::ERROR,displayedSeconds: 8));
        \App\Facade\NotificationMessage::addNotificationMessage(new \App\NotificationMessage\Item("test4", \App\NotificationMessage\ItemType::WARNING,displayedSeconds: 12));
//        dd(\App\Facade\NotificationMessage::popNotificationMessagesJson());
@endphp

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('notificationMessages', {
            messages: Alpine.$persist({}),
            addNotificationMessages(newMessages) {
                for(let message of newMessages) {
                    this.messages[message.timestamp] = message;
                }
            },
            removeNotificationMessage(timestamp) {
                delete this.messages[timestamp];
            }
        });
        console.log("add messages");
        Alpine.store('notificationMessages').addNotificationMessages(
            JSON.parse('<?= \App\Facade\NotificationMessage::popNotificationMessagesJson() ?>'));
    });
</script>

<div x-data class="fixed overflow-auto top-3 right-0 max-w-7xl sm:px-6 lg:px-8 space-y-1">
    <template x-for="message in $store.notificationMessages.messages" :key="message.timestamp">
        <div x-data="{show:true, hideAndRemove() {
            this.show = false;
            setTimeout(()=>$store.notificationMessages.removeNotificationMessage(message.timestamp), 1000);
        }}"
             x-init="setTimeout(hideAndRemove, message.displayedSeconds*1000)"
             x-show="show" x-collapse>
            <div class="flex gap-4 items-center px-4 bg-white border border-t-4 shadow-xl opacity-90"
                 role="alert"
                 :class="{
                    'border-t-green-700': message.type === 'SUCCESS',
                    'border-t-yellow-500': message.type === 'WARNING',
                    'border-t-red-700': message.type === 'ERROR',
                    'border-t-blue-700': message.type === 'INFORMATION'
                    }"
            >
                <i class="fa-solid"
                   :class="{
                'fa-circle-check text-green-700': message.type === 'SUCCESS',
                'fa-triangle-exclamation text-yellow-500': message.type === 'WARNING',
                'fa-circle-xmark text-red-700': message.type === 'ERROR',
                'fa-info-circle text-blue-700': message.type === 'INFORMATION',
                }"></i>
                <div class="py-2">
                    <template x-if="message.title">
                        <span x-text="message.title" class="font-bold"></span>
                    </template>

                    <p x-text="message.message"></p>
                </div>
                <button class="ml-auto" x-on:click="hideAndRemove()"><i class="fa-solid fa-xmark text-gray-500"></i>
                </button>
            </div>
        </div>
    </template>
</div>
