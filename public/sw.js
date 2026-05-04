const CACHE_NAME = 'vigate-cache-v1';
const OFFLINE_URL = '/offline.html';
const ASSETS_TO_CACHE = [
    '/',
    OFFLINE_URL,
    '/favicon_io/site.webmanifest',
    '/favicon_io/android-chrome-192x192.png',
    '/favicon_io/android-chrome-512x512.png',
    '/favicon_io/favicon-32x32.png',
    '/favicon_io/favicon-16x16.png',
    '/favicon_io/apple-touch-icon.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS_TO_CACHE))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(
                keys
                    .filter((key) => key !== CACHE_NAME)
                    .map((key) => caches.delete(key))
            )
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }

    const requestURL = new URL(event.request.url);

    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .then((response) => {
                    const copy = response.clone();
                    caches.open(CACHE_NAME).then((cache) => cache.put(event.request, copy));
                    return response;
                })
                .catch(() => caches.match(OFFLINE_URL))
        );
        return;
    }

    if (requestURL.origin === self.location.origin) {
        event.respondWith(
            caches.match(event.request).then((cachedResponse) => {
                if (cachedResponse) {
                    return cachedResponse;
                }
                return fetch(event.request)
                    .then((networkResponse) => {
                        if (
                            networkResponse &&
                            networkResponse.status === 200 &&
                            networkResponse.type !== 'opaque'
                        ) {
                            const responseClone = networkResponse.clone();
                            caches.open(CACHE_NAME).then((cache) => cache.put(event.request, responseClone));
                        }
                        return networkResponse;
                    })
                    .catch(() => {
                        if (event.request.destination === 'image') {
                            return caches.match('/favicon_io/android-chrome-192x192.png');
                        }
                        if (event.request.destination === 'document') {
                            return caches.match(OFFLINE_URL);
                        }
                    });
            })
        );
    }
});
