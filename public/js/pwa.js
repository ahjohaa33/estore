// public/js/pwa.js
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
        navigator.serviceWorker.register('/service-worker.js')
            .then(function (reg) {
                console.log('Service worker registered.', reg.scope);
            })
            .catch(function (err) {
                console.warn('Service worker registration failed:', err);
            });
    });
}
