self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        //notifications aren't supported or permission not granted!
        return;
    }

    if (event.data) {
        const msg = event.data.json();
        event.waitUntil(
            self.registration.showNotification(msg.title, {
                body: msg.body,
                icon: msg.icon,
                actions: msg.actions,
                data: msg.data
            })
        );
    }
});

self.addEventListener('notificationclick', function (event) {

    event.notification.close();

    if (event.action === 'event-detail') {
        if (event.notification.data.id) {
            clients.openWindow("/events/" + event.notification.data.id + "/detail");
        } else {
            clients.openWindow("/events");
        }
    } else if (event.action === 'news-detail') {
        if (event.notification.data.id) {
            clients.openWindow("/news/" + event.notification.data.id + "/detail");
        } else {
            clients.openWindow("/news");
        }
    } else {
        clients.openWindow("/");
    }
}, false);
