// public/sw.js

// Escuchar el evento de notificación push enviado desde Laravel
self.addEventListener('push', function(event) {
    if (!event.data) return;

    const payload = event.data.json();
    const options = {
        body: payload.body,
        icon: payload.icon || '/images/logo-icon.png',
        badge: payload.badge || '/images/badge-icon.png',
        data: {
            // Guardamos la URL de la rutina que viene desde Laravel
            url: payload.data.url 
        },
        vibrate: [200, 100, 200],
        requireInteraction: true
    };

    event.waitUntil(
        self.registration.showNotification(payload.title, options)
    );
});

// Escuchar el click sobre la notificación y redirigir
self.addEventListener('notificationclick', function(event) {
    event.notification.close(); // Cierra el banner

    const targetUrl = event.notification.data.url;

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            // Si la aplicación ya estaba abierta en alguna pestaña, la navega y le hace foco
            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if ('focus' in client) {
                    client.navigate(targetUrl);
                    return client.focus();
                }
            }
            // Si estaba completamente cerrada, abre una nueva ventana con la url de la rutina
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});