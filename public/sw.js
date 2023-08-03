self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (event.data) {
        const msg = event.data.json();
        console.log(msg)
        event.waitUntil(
            self.registration.showNotification(msg.title, {
                body: msg.body,
                icon: msg.icon,
                actions: msg.actions
            })
        );
    }
});

self.addEventListener('notificationclick', function(event) {
    console.log(event.notification.data);

    event.notification.close();

    if (event.action === 'events') {
        clients.openWindow("/events");
    } else if (event.action === 'news') {
        clients.openWindow("/news");
    } else {
        clients.openWindow("/");
    }
}, false);
