const webPush = {
    vapidPublicKey: import.meta.env.VITE_VAPID_PUBLIC_KEY,

    checkBrowserRequirements: () => {

        if (!"serviceWorker" in navigator) {
            //service worker isn't supported
            return false;
        }

        //don't use it here if you use service worker
        //for other stuff.
        if (!"PushManager" in window) {
            //push isn't supported
            return false;
        }
    },

    serviceWorker: {

        hasServiceWorker: () => {
            return navigator.serviceWorker.getRegistration().then(reg => {
                return reg !== undefined;
            }).catch(() => {
                return false;
            });
        },

        registerServiceWorker: () => {
            return navigator.serviceWorker.register('../sw.js')
                .then(() => {
                    console.log('serviceWorker installed!')
                    return true;
                })
                .catch((err) => {
                    return false;
                });
        },

        unregisterServiceWorker: () => {
            navigator.serviceWorker.getRegistration().then(swr => {
                swr?.unregister().then(unreg => {
                    console.log("service worker unregistering: " + unreg);
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
                return swr.pushManager.getSubscription().then(sub => {
                    if (webPush.urlBase64ToUint8Array(webPush.vapidPublicKey).toString() === new Uint8Array(sub.options.applicationServerKey).toString()) {
                        return sub;
                    }
                    return false;
                });
            }).catch(err => {
                return false;
            });
        },

        removePushSubscription: async () => {
            return navigator.serviceWorker.ready.then(swr => {
                return swr.pushManager.getSubscription().then(sub => {
                    return sub.unsubscribe().then((fulfilled => {
                        return fulfilled
                    }));
                });
            }).catch(() => {
                return false;
            });
        },

        addPushSubscription: () => {
            return navigator.serviceWorker.ready
                .then((registration) => {
                    const subscribeOptions = {
                        userVisibleOnly: true,
                        applicationServerKey: webPush.urlBase64ToUint8Array(webPush.vapidPublicKey)
                    };

                    return registration.pushManager.subscribe(subscribeOptions).then(pushSub => {
                        return pushSub instanceof PushSubscription;
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
                        return res.status === 200;
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
                        return res.status === 200;
                    })
                    .catch((err) => {
                        console.log(err)
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
                        return res.status === 200;
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
    }
}

export default webPush;


