const webPush = {
    errors: [],
    info: {
        errors: null,
        isNotificationSupported: null,
        notification: {
            hasNotificationPermission: null,
            notificationPermission: null,
        },
        isPushManagerSupported: null,
        isServiceWorkerSupported: null,
        serviceWorker: {
            hasServiceWorker: null,
            serviceWorkerUrl: null,
            object: null,
            pushManager: {
                hasPushManager: null,
                object: null,
                subscription: {
                    hasSubscription: null,
                    serverKeyIsSameAsVapid: null,
                    server: {
                        isPushSubscriptionStored: null
                    }
                }
            }
        },
        storedVapidPublicKey: null,
    },
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
                document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                return result === "granted";
            });
        }
    },
    serviceWorker: {
        isServiceWorkerSupported() {
            return "serviceWorker" in navigator;
        },
        hasServiceWorker() {
            return !!navigator.serviceWorker.controller;
        },
        // reload is required afterwards
        registerServiceWorker: () => {
            return navigator.serviceWorker.register('/sw.js').then((swr) => {
                console.log('service worker registered');
                document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                return swr;
            });
        },
        getServiceWorkerRegistration: async () => {
            return await navigator.serviceWorker.getRegistration();
        },
        unregisterServiceWorker: () => {
            return navigator.serviceWorker.getRegistration().then(swr => {
                return swr?.unregister().then(() => {
                    document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                });
            })
        },
    },

    vapid: {
        getVapidPublicKey: function () {
            let vapid = this.getStoredVapidPublicKey();
            if (vapid?.length > 0) return vapid;
            return this.getVapidPublicKeyFromServer();
        },
        getStoredVapidPublicKey: function () {
            return localStorage.getItem("vapidPublicKey");
        },

        setStoredVapidPublicKey: function (publicKey) {
            localStorage.setItem("vapidPublicKey", publicKey);
            document.dispatchEvent(new CustomEvent('web-push-info-changed'));
        },

        getVapidPublicKeyFromServer: async function (store = true) {
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
                    if (store) this.setStoredVapidPublicKey(res.public_key);
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
        addPushSubscription: async () => {
            return await navigator.serviceWorker.ready
                .then(async (registration) => {
                    const vapidKey = await webPush.vapid.getVapidPublicKey();
                    const subscribeOptions = {
                        userVisibleOnly: true,
                        applicationServerKey: webPush.urlBase64ToUint8Array(vapidKey)
                    };

                    return await registration.pushManager.subscribe(subscribeOptions);
                }).catch((err) => {
                    webPush.errors.push('exception while adding push subscription: ' + err.message);
                    console.log(err);
                }).finally(() => {
                    document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                });
        },

        removePushSubscription: async () => {
            return navigator.serviceWorker.ready.then(async swr => {
                return await swr.pushManager.getSubscription().then(async sub => {
                    return await sub.unsubscribe();
                });
            }).catch(() => {
                webPush.errors.push('exception while removing push subscription: ' + err.message);
            }).finally(() => {
                document.dispatchEvent(new CustomEvent('web-push-info-changed'));
            });
        },
    },

    server: {

        storePushSubscription: async () => {

            const sub = await (await navigator.serviceWorker.getRegistration())?.pushManager?.getSubscription();

            if (!sub) {
                webPush.errors.push('no push subscription to check for');
                document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                return null;
            }
            return webPush.server.storeGivenPushSubscription(sub);
        },

        storeGivenPushSubscription: async (pushSubscription) => {
            const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

            return await fetch('/webPush', {
                method: 'POST', body: JSON.stringify(pushSubscription), headers: {
                    'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-Token': token
                }
            })
                .then((res) => {
                    return res.status === 200;
                })
                .catch((err) => {
                    webPush.errors.push("Error while getting storing key on server: "+err.message)
                    console.log(err)
                }).finally(() => {
                    document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                });
        },

        isPushSubscriptionStored: async () => {
            const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

            const sub = await (await navigator.serviceWorker.getRegistration())?.pushManager?.getSubscription();

            if (!sub) {
                webPush.errors.push('no push subscription to check for');
                document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                return null;
            }

            return await fetch('/webPush/hasEndpoint', {
                method: 'POST', body: JSON.stringify({
                    endpoint: sub.endpoint
                }), headers: {
                    'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-Token': token
                }
            })
                .then((res) => {
                    return res.status === 200;
                })
                .catch((err) => {
                    return false;
                });
        },

        removePushSubscription: async () => {
            const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

            const sub = await (await navigator.serviceWorker.getRegistration())?.pushManager?.getSubscription();

            if (!sub) {
                webPush.errors.push('no push subscription to check for');
                document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                return null;
            }

            return await fetch('/webPush/removeEndpoint', {
                method: 'POST', body: JSON.stringify({
                    endpoint: sub.endpoint
                }), headers: {
                    'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-Token': token
                }
            })
                .catch((err) => {
                    webPush.errors.push("Error while removing subscription from server: "+err.message)
                    console.log(err)
                }).finally(() => {
                    document.dispatchEvent(new CustomEvent('web-push-info-changed'));
                });
        }
    },


    isPushManagerSupported() {
        return "PushManager" in window;
    },

    async checkAll() {
        this.info = {
            errors: this.errors,
            isNotificationSupported: null,
            notification: {
                hasNotificationPermission: null,
                notificationPermission: null,
            },
            isPushManagerSupported: null,
            isServiceWorkerSupported: null,
            serviceWorker: {
                hasServiceWorker: null,
                serviceWorkerUrl: null,
                object: null,
                pushManager: {
                    hasPushManager: null,
                    object: null,
                    subscription: {
                        hasSubscription: null,
                        serverKeyIsSameAsVapid: null,
                        server: {
                            isPushSubscriptionStored: null
                        }
                    }
                }
            },
            storedVapidPublicKey: null,
        };
        this.info.storedVapidPublicKey = this.vapid.getStoredVapidPublicKey();
        this.info.isNotificationSupported = this.notification.isNotificationSupported();
        this.info.notification.hasNotificationPermission = this.notification.hasNotificationPermission();
        this.info.notification.notificationPermission = this.notification.getNotificationApiPermissionStatus();
        this.info.isPushManagerSupported = this.isPushManagerSupported();
        this.info.isServiceWorkerSupported = this.serviceWorker.isServiceWorkerSupported();
        const serviceWorkerRegistration = await this.serviceWorker.getServiceWorkerRegistration();
        this.info.serviceWorker.hasServiceWorker = !!serviceWorkerRegistration;
        if (serviceWorkerRegistration && serviceWorkerRegistration.active) {
            this.info.serviceWorker.serviceWorkerUrl = serviceWorkerRegistration.active.scriptURL;
            this.info.serviceWorker.object = serviceWorkerRegistration;
            const pushManager = serviceWorkerRegistration.pushManager;
            this.info.serviceWorker.pushManager.hasPushManager = !!pushManager;
            if (pushManager) {
                this.info.serviceWorker.pushManager.object = pushManager;
                const subscription = await pushManager.getSubscription();
                this.info.serviceWorker.pushManager.subscription.hasSubscription = !!subscription;
                if (subscription) {
                    this.info.serviceWorker.pushManager.subscription.serverKeyIsSameAsVapid =
                        this.info.storedVapidPublicKey && this.urlBase64ToUint8Array(this.info.storedVapidPublicKey).toString() ===
                        new Uint8Array(subscription.options.applicationServerKey).toString();
                    this.info.serviceWorker.pushManager.subscription.server.isPushSubscriptionStored =
                        await this.server.isPushSubscriptionStored();
                }
            }
        }
        return this.info;
    },


    urlBase64ToUint8Array: (base64String) => {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');

        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);

        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    },
}

if(webPush.serviceWorker.isServiceWorkerSupported() &&
    !webPush.serviceWorker.hasServiceWorker()) {
    webPush.serviceWorker.registerServiceWorker();
}

export default webPush;
