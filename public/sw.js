self.addEventListener('push', function (event) {
    if (!event.data) return;
    
    const payload = event.data.json();
    
    const options = {
        body: payload.body,
        icon: '/images/logo-notification.png', 
        badge: '/images/badge.png',
        vibrate: [100, 50, 100],
        data: {
            url: payload.url || '/routines'
        }
    };

    event.waitUntil(
        self.registration.showNotification(payload.title, options)
    );
});

// Al hacer clic en la push, redirigir a la rutina
self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});