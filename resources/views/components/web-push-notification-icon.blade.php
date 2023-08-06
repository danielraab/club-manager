<script>
    function initNotificationIconFunctions() {

        return {
            addClasses: '', title: [], clickAction: null,

            requestNotificationPermission() {
                webPush.notification.requestNotificationPermission().then(async (allowed) => {
                    console.log("request result", allowed)
                    if (allowed) alert("Please reload the page.");
                })
            },

            updateData() {
                if(webPush.isReady()) {
                    this.addClasses = 'fa-solid text-green-700';
                    return;
                }

                this.addClasses = 'text-red-700';
                this.title = [];

                if (webPush.isBrowserReady === false) {
                    this.title.push("The browser is not ready to receive notifications.");
                }
                if (!webPush.notification.isNotificationGranted()) {
                    this.title.push("Notification access is not granted.")

                    if(webPush.notification.getNotificationPermission() === "default") {
                        this.addClasses += " cursor-pointer";
                        this.clickAction = this.requestNotificationPermission;
                    }
                }

                if (webPush.hasServiceWorker === false) {
                    this.title.push("The service worker is not installed.");
                }

                if (webPush.hasPushSubscription) {
                    this.title.push("No push subscription is registered.");
                }

                if (webPush.isPushSubscriptionStored) {
                    this.title.push("The push subscription is not stored at the server.");
                }

            }
        }
    }
</script>
<i x-data="initNotificationIconFunctions()"
   x-bind:class="addClasses"
   x-bind:title="title.join(' \n')"
   x-on:click="clickAction"
   x-on:webpush-setup-finished.window="updateData()"
   class="fa-regular fa-bell"></i>
