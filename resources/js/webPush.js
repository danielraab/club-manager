const webPush = {
    errors: [],
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
        requestNotificationPermission: () => {
            return Notification.requestPermission().then(result => {
                return result === "granted";
            });
        }
    },
    serviceWorker: {
        isServiceWorkerSupported() {
            return "serviceWorker" in navigator;
        },
        hasServiceWorker() {
            console.log('sw', !!navigator.serviceWorker.controller);
            return !!navigator.serviceWorker.controller;
        },
        getServiceWorkerScriptUrl() {
            return navigator.serviceWorker.controller.scriptURL;
        },
        registerServiceWorker: () => {
            return navigator.serviceWorker.register('/sw.js')
        }
    },

    vapid: {
        isVapidPublicKeyStored: function () {
            let vapidPublicKey = localStorage.getItem("vapidPublicKey");
            return vapidPublicKey && vapidPublicKey.length > 0;
        },

        getStoredVapidPublicKey: function () {
            return localStorage.getItem("vapidPublicKey");
        },

        setStoredVapidPublicKey: function (publicKey) {
            localStorage.setItem("vapidPublicKey", publicKey);
        },

        getVapidPublicKeyFromServer: async function ()  {
            const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

            return await fetch('/webPush/vapidPublicKey', {
                method: 'GET', headers: {
                    'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-Token': token
                }
            })
                .then((res) => {
                    return res.json();
                })
                .then((res) => {
                     return res.public_key;
                })
                .catch((err) => {
                    webPush.errors.push("Error while getting vapid public key from server.")
                    console.log(err)
                    return null;
                });
        },
    },

    subscription: {

        getPushSubscription: () => {
            return navigator.serviceWorker.ready.then(swr => {
                return swr.pushManager.getSubscription().then(async sub => {
                    const vapidPubKey = await webPush.getVapidPublicKey();
                    if (webPush.urlBase64ToUint8Array(vapidPubKey).toString() === new Uint8Array(sub.options.applicationServerKey).toString()) {
                        webPush.hasPushSubscription = true;
                        return sub;
                    }
                    webPush.hasPushSubscription = false;
                    return false;
                });
            }).catch(err => {
                webPush.errors.push("unable to get service worker")
                console.log(err);
                webPush.hasPushSubscription = false;
                return false;
            });
        },
    },


    isPushManagerSupported() {
        return "PushManager" in window;
    }
}

export default webPush;


