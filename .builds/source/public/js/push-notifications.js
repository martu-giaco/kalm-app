document.addEventListener('DOMContentLoaded', function () {
    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        console.warn('Este navegador no soporta notificaciones push.');
        return;
    }

    const vapidPublicKey = document.querySelector('meta[name="vapid-public-key"]')?.content;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!vapidPublicKey || !csrfToken) return;

    navigator.serviceWorker.register('/service-worker.js')
        .then(function (registration) {
            return registration.pushManager.getSubscription().then(function (existing) {
                if (existing) return existing;

                return Notification.requestPermission().then(function (permission) {
                    if (permission !== 'granted') {
                        throw new Error('Permiso de notificaciones denegado');
                    }

                    return registration.pushManager.subscribe({
                        userVisibleOnly: true,
                        applicationServerKey: urlBase64ToUint8Array(vapidPublicKey),
                    });
                });
            });
        })
        .then(function (subscription) {
            return fetch('/push/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(subscription),
            });
        })
        .catch(function (err) {
            console.warn('No se pudo suscribir a notificaciones push:', err.message);
        });
});

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}