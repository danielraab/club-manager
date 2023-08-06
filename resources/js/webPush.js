const webPush = {
    isBrowserReady: null,
    hasServiceWorker: null,
    hasPushSubscription: null,
    isPushSubscriptionStored: null,
    forceIsReady: false,

    getVapidPublicKey: async function ()  {
        let vapidPublicKey = localStorage.getItem("vapidPublicKey");
        if(vapidPublicKey && vapidPublicKey.length > 0) return vapidPublicKey;

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
                const publicKey = res.public_key;
                localStorage.setItem("vapidPublicKey", publicKey);
                return publicKey;
            })
            .catch((err) => {
                console.log(err)
                return null;
            });
    },

    isReady() {
        return this.forceIsReady ||
            (this.isBrowserReady &&
                this.notification.isNotificationGranted() &&
                this.hasServiceWorker &&
                this.hasPushSubscription &&
                this.isPushSubscriptionStored);
    },

    checkBrowserRequirements: function () {
        this.isBrowserReady = true;

        if (!"serviceWorker" in navigator) {
            console.log("service Worker not supported in this browser.");
            this.isBrowserReady = false;
        }

        //don't use it here if you use service worker
        //for other stuff.
        if (!"PushManager" in window) {
            console.log("push manager not supported in this browser.")
            this.isBrowserReady = false;
        }
        return this.isBrowserReady;
    },

    serviceWorker: {

        hasServiceWorker: () => {
            return navigator.serviceWorker.getRegistration().then(reg => {
                webPush.hasServiceWorker = reg !== undefined;
                return webPush.hasServiceWorker;
            }).catch(() => {
                webPush.hasServiceWorker = false;
                return false;
            });
        },

        registerServiceWorker: () => {
            return navigator.serviceWorker.register('../sw.js')
                .then(() => {
                    console.log('serviceWorker installed!')
                    webPush.hasServiceWorker = true;
                    return true;
                })
                .catch((err) => {
                    webPush.hasServiceWorker = false;
                    return false;
                });
        },

        unregisterServiceWorker: () => {
            navigator.serviceWorker.getRegistration().then(swr => {
                swr?.unregister().then(unreg => {
                    console.log("service worker unregistering: " + unreg);
                    webPush.hasServiceWorker = false;
                });
            })
        },
    },

    notification: {

        getNotificationPermission: () => {
            return Notification.permission;
        },

        isNotificationGranted: () => {
            return Notification.permission === 'granted';
        },

        requestNotificationPermission: () => {
            return Notification.requestPermission().then(result => {
                return result === "granted";
            });
        }
    },

    pushSubscription: {

        getPushSubscription: () => {
            return navigator.serviceWorker.ready.then(swr => {
                return swr.pushManager.getSubscription().then(async sub => {
                    if (webPush.urlBase64ToUint8Array(await webPush.getVapidPublicKey()).toString() === new Uint8Array(sub.options.applicationServerKey).toString()) {
                        webPush.hasPushSubscription = true;
                        return sub;
                    }
                    webPush.hasPushSubscription = false;
                    return false;
                });
            }).catch(err => {
                webPush.hasPushSubscription = false;
                return false;
            });
        },

        removePushSubscription: async () => {
            return navigator.serviceWorker.ready.then(swr => {
                return swr.pushManager.getSubscription().then(sub => {
                    return sub.unsubscribe().then((result => {
                        if (result) webPush.hasPushSubscription = false;
                        return result
                    }));
                });
            }).catch(() => {
                return false;
            });
        },

        addPushSubscription: () => {
            return navigator.serviceWorker.ready
                .then(async (registration) => {
                    const subscribeOptions = {
                        userVisibleOnly: true,
                        applicationServerKey: webPush.urlBase64ToUint8Array(await webPush.getVapidPublicKey())
                    };

                    return registration.pushManager.subscribe(subscribeOptions).then(pushSub => {
                        if (pushSub instanceof PushSubscription) {
                            webPush.hasPushSubscription = true;
                            return pushSub;
                        }
                        return false;
                    });
                }).catch(() => {
                    return false;
                })
        },

        store: {

            storePushSubscription: (pushSubscription) => {
                const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

                return fetch('/webPush', {
                    method: 'POST', body: JSON.stringify(pushSubscription), headers: {
                        'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-Token': token
                    }
                })
                    .then((res) => {
                        webPush.isPushSubscriptionStored = res.status === 200;
                        return webPush.isPushSubscriptionStored;
                    })
                    .catch((err) => {
                        console.log(err)
                        return false;
                    });
            },

            isPushSubscriptionStored: (pushSubscription) => {
                const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

                return fetch('/webPush/hasEndpoint', {
                    method: 'POST', body: JSON.stringify({
                        endpoint: pushSubscription.endpoint
                    }), headers: {
                        'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-Token': token
                    }
                })
                    .then((res) => {
                        webPush.isPushSubscriptionStored = res.status === 200;
                        return webPush.isPushSubscriptionStored;
                    })
                    .catch((err) => {
                        webPush.isPushSubscriptionStored = false;
                        return false;
                    });
            },

            removePushSubscriptionFromStore: (pushSubscription) => {
                const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

                return fetch('/webPush/removeEndpoint', {
                    method: 'POST', body: JSON.stringify({
                        endpoint: pushSubscription.endpoint
                    }), headers: {
                        'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-Token': token
                    }
                })
                    .then((res) => {
                        if (res.status === 200) {
                            webPush.isPushSubscriptionStored = false;
                            return true;
                        }
                        return false;
                    })
                    .catch((err) => {
                        console.log(err)
                        return false;
                    });
            }
        }
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

    setupAll: async function () {
        let checksSuccessful = true;

        let lastSetup = localStorage.getItem('clubManagerSubscriptionCheck');
        if(lastSetup && (Number(lastSetup) < Date.now()+300000)) {
            this.forceIsReady = true;
            console.log("webPush check timestamp found");
            window.dispatchEvent(new CustomEvent("webpush-setup-finished"))
            return true;
        }

        if (!webPush.checkBrowserRequirements()) checksSuccessful = false;

        if (checksSuccessful && !webPush.notification.isNotificationGranted()) {
            if (!(await webPush.notification.requestNotificationPermission())) {
                console.log("unable to request notification permission.")
                checksSuccessful = false;
            }
        }

        if (checksSuccessful && !(await webPush.serviceWorker.hasServiceWorker())) {
            if (!(await webPush.serviceWorker.registerServiceWorker())) {
                console.log('unable to install serviceWorker');
                checksSuccessful = false;
            }
        }

        let pushSubscription = null;
        if (checksSuccessful && !(pushSubscription = await webPush.pushSubscription.getPushSubscription())) {
            if (!(pushSubscription = await webPush.pushSubscription.addPushSubscription())) {
                console.log("unable to add push subscription to manager");
                checksSuccessful = false;
            }
        }

        if (checksSuccessful && !(await webPush.pushSubscription.store.isPushSubscriptionStored(pushSubscription))) {
            if (!(await webPush.pushSubscription.store.storePushSubscription(pushSubscription))) {
                console.log("unable to store subscription on server");
                checksSuccessful = false;
            }
        }

        window.dispatchEvent(new CustomEvent("webpush-setup-finished"))

        if (checksSuccessful) {
            localStorage.setItem("clubManagerSubscriptionCheck", Date.now().toString());
        }

        return checksSuccessful;
    }
}

export default webPush;


