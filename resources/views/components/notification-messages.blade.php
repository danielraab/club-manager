<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('notificationMessages', {
            messages: Alpine.$persist({}),
            addNotificationMessages(newMessages) {
                for(let message of newMessages) {
                    if(!message.timestamp) message.timestamp = Date.now();
                    if(!message.type) message.type = "INFORMATION";
                    if(!message.displayedSeconds) message.displayedSeconds = 5;
                    this.messages[message.timestamp] = message;
                }
            },
            removeNotificationMessage(timestamp) {
                delete this.messages[timestamp];
            }
        });
        Alpine.store('notificationMessages').addNotificationMessages(
            JSON.parse('{!! \App\Facade\NotificationMessage::popNotificationMessagesJson() !!}')
        );
    });
</script>

<div x-data class="fixed overflow-auto top-12 right-0 max-w-7xl sm:px-6 lg:px-8 space-y-2 z-50">
    <template x-for="message in $store.notificationMessages.messages" :key="message.timestamp">
        <div x-data="{
            show:true, progress: 100, shrinkInterval:undefined,
            getProgressStyle(){return 'width:'+this.progress+'%'},
            hideAndRemove() {
                this.show = false;
                clearInterval(this.shrinkInterval);
                setTimeout(()=>$store.notificationMessages.removeNotificationMessage(message.timestamp), 1000);
            },
            startShrinkProgress() {
                if(message.displayedSeconds > 0) {
                    if(message.progress && message.progress > 0 && message.progress < 100) {
                        this.progress = message.progress;
                    }
                    this.shrinkInterval = setInterval(()=>{
                        this.progress = this.progress - ((100*100) / (message.displayedSeconds*1000));
                        if(this.progress <= 0) {
                            this.progress = 0
                            this.hideAndRemove();
                            return;
                        }
                        if(!message.progress || (message.progress - this.progress) > 20) { // update progress in storage
                            message.progress = this.progress;
                        }
                    },100);
                }
            }
        }"
             x-init="startShrinkProgress()"
             x-show="show" x-collapse>
            <div class="flex gap-4 items-center px-4 shadow-xl opacity-90 text-white"
                 role="alert"
                 :class="{
                    'bg-green-700': message.type === 'SUCCESS',
                    'bg-yellow-500': message.type === 'WARNING',
                    'bg-red-700': message.type === 'ERROR',
                    'bg-blue-700': message.type === 'INFORMATION'
                    }"
            >
                <i class="fa-solid"
                   :class="{
                'fa-circle-check': message.type === 'SUCCESS',
                'fa-triangle-exclamation': message.type === 'WARNING',
                'fa-circle-xmark': message.type === 'ERROR',
                'fa-info-circle': message.type === 'INFORMATION'
                }"></i>
                <div class="py-2">
                    <template x-if="message.title">
                        <span x-text="message.title" class="font-bold"></span>
                    </template>

                    <p x-text="message.message"></p>
                </div>
                <button class="ml-auto" x-on:click="hideAndRemove()"><i class="fa-solid fa-xmark opacity-50"></i>
                </button>
            </div>
            <div class="h-[3px] mx-auto"
                :class="{
                    'bg-green-700': message.type === 'SUCCESS',
                    'bg-yellow-500': message.type === 'WARNING',
                    'bg-red-700': message.type === 'ERROR',
                    'bg-blue-700': message.type === 'INFORMATION'
                    }"
                :style="getProgressStyle()"></div>
        </div>
    </template>
</div>
