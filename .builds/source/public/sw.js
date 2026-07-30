// public/sw.js

// Escuchar el evento de notificación push enviado desde Laravel
self.addEventListener('push', function(event) {
    if (!event.data) return;

    let payload;
    try {
        payload = event.data.json();
    } catch (e) {
        // Por si envías texto plano en lugar de un JSON estructurado
        payload = { title: '¡Nueva notificación!', body: event.data.text() };
    }

    const options = {
        body: payload.body,
        icon: payload.icon || '/images/logo-icon.png',
        badge: payload.badge || '/images/badge-icon.png',
        data: {
            // MEJORA: Evitamos errores si payload.data o payload.data.url no existen en el envío
            url: (payload.data && payload.data.url) ? payload.data.url : '/'
        },
        vibrate: [200, 100, 200],
        requireInteraction: true
    };

    event.waitUntil(
        self.registration.showNotification(payload.title || 'Kälm', options)
    );
});

// Escuchar el click sobre la notificación y redirigir
self.addEventListener('notificationclick', function(event) {
    event.notification.close(); // Cierra el banner

    // Si no hay url asignada, redirige a la raíz de la web
    const targetUrl = event.notification.data.url || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            // Si la aplicación ya estaba abierta en alguna pestaña, navega en ella y le hace foco
            for (let i = 0; i < clientList.length; i++) {
                let client = clientList[i];
                if ('focus' in client) {
                    client.navigate(targetUrl);
                    return client.focus();
                }
            }
            // Si estaba completamente cerrada, abre una nueva ventana/pestaña
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});