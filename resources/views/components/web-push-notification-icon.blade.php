<script>
    function initNotificationIconFunctions() {

        return {
            addClasses: [], title: [], clickAction: null,

            init() {
                webPush.setupAll(true);
            },

            updateData() {
                this.addClasses = [];
                this.title = [];

                if (webPush.isReady()) {
                    this.addClasses.push('fa-solid', 'text-green-700');
                    this.title.push("Web push notifications enabled and active.");
                    return;
                }

                this.addClasses.push('text-red-700');

                if (webPush.isBrowserReady === false) {
                    this.title.push("The browser is not ready to receive notifications.");
                    return;
                }
                if (!webPush.notification.isNotificationGranted()) {
                    if (webPush.notification.getNotificationPermission() !== "default") {
                        this.title.push("Notification access is blocked! Please check your settings.")
                        return;
                    }
                    this.title.push("Notification access is not granted.")
                }

                this.addClasses.push("cursor-pointer");
                this.clickAction = () => webPush.setupAll(false);

                if (!webPush.hasServiceWorker === false) {
                    this.title.push("The service worker is not installed.");
                }

                if (!webPush.hasPushSubscription === false) {
                    this.title.push("No push subscription is registered.");
                }

                if (!webPush.isPushSubscriptionStored === false) {
                    this.title.push("The push subscription is not stored at the server.");
                }
            }
        }
    }
</script>
<div class="flex items-center">
<i x-data="initNotificationIconFunctions()"
   x-bind:class="addClasses"
   x-bind:title="title.join(' \n')"
   x-on:click="clickAction"
   x-on:webpush-setup-finished.window="updateData()"
   class="fa-regular fa-bell"></i>
</div>
