self.addEventListener('push', function (event) {
    if (!event.data) return;

    const payload = event.data.json();
    const data = payload.notification ?? payload; // soporta ambos formatos

    const options = {
        body: data.body,
        icon: data.icon || '/images/icon-192.png',
        data: data.data,
        actions: data.actions || [],
        requireInteraction: true,
    };

    event.waitUntil(self.registration.showNotification(data.title, options));
});