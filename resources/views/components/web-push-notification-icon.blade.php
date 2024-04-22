<script>
    function initNotificationIconFunctions() {

        return {
            info: webPush.info,
            successfullySubscribed: false,
            hasSomeErrors: false,
            clickAction: null,

            async updateData() {
                this.successfullySubscribed = false;
                this.hasSomeErrors = false;

                this.info = (await webPush.checkAll());


                if (this.info.serviceWorker.pushManager.subscription.hasSubscription &&
                    this.info.serviceWorker.pushManager.subscription.serverKeyIsSameAsVapid &&
                    this.info.serviceWorker.pushManager.subscription.server.isPushSubscriptionStored) {
                    this.successfullySubscribed = true;
                } else {
                    this.clickAction = async () => {
                        await webPush.subscription.addPushSubscription();
                        await webPush.server.storePushSubscription();
                    };
                }
                if (this.info.errors.length > 0) this.hasSomeErrors = true;
            }
        }
    }
</script>
<div class="flex items-center">
    <i x-init="updateData()"
        x-data="initNotificationIconFunctions()"
       x-bind:class="{
   'cursor-pointer': !hasSomeErrors && !successfullySubscribed,
   'fa-solid text-green-700': !hasSomeErrors && successfullySubscribed,
   'text-red-700': hasSomeErrors
   }"
       x-on:click="clickAction"
       @web-push-info-changed.document="updateData()"
       class="fa-regular fa-bell"></i>
</div>
