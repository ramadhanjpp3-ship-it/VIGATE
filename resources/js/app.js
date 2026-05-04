import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                console.log('Service worker registered with scope:', registration.scope);
            })
            .catch((error) => {
                console.warn('Service worker registration failed:', error);
            });
    });
}

let deferredInstallPrompt = null;
window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    deferredInstallPrompt = event;
    window.dispatchEvent(new CustomEvent('pwa-install-ready'));
});

window.addEventListener('appinstalled', () => {
    console.log('PWA installed');
    deferredInstallPrompt = null;
});
