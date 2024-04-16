const webPush = {
    notification: {
        isNotificationSupported() {
            return typeof Notification !== "undefined"
        },
        getNotificationApiPermissionStatus() {
            return typeof Notification !== "undefined"
                ? Notification.permission
                : "Notification API unsupported"
        },
        hasNotificationPermission() {
            return this.getNotificationApiPermissionStatus() === "granted";
        },
    },
    serviceWorker: {
        isServiceWorkerSupported() {
            return "serviceWorker" in navigator;
        },
        hasServiceWorker() {
            return !!navigator.serviceWorker.controller;
        },
        getServiceWorkerScriptUrl() {
            return navigator.serviceWorker.controller.scriptURL;
        },
        registerServiceWorker: () => {
            return navigator.serviceWorker.register('/sw.js')
        }
    },
    isPushManagerSupported() {
        return "PushManager" in window;
    }
}

export default webPush;


