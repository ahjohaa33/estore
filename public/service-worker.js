// public/service-worker.js

const STATIC_CACHE = 'static-v4';      // bump this to clear old
const RUNTIME_CACHE = 'runtime-v4';

// list the static assets you know won't change often
// best: generate this list on build
const PRECACHE_ASSETS = [
  '/',                      // homepage
  '/css/bootstrap.min.css',
  '/css/tabler-icons.min.css',
  '/css/animate.css',
  '/css/owl.carousel.min.css',
  '/css/magnific-popup.css',
  '/css/nice-select.css',
  '/css/style.css',
  '/js/bootstrap.bundle.min.js',
  '/js/jquery.min.js',
  '/js/waypoints.min.js',
  '/js/jquery.easing.min.js',
  '/js/owl.carousel.min.js',
  '/js/jquery.magnific-popup.min.js',
  '/js/jquery.counterup.min.js',
  '/js/jquery.countdown.min.js',
  '/js/jquery.passwordstrength.js',
  '/js/jquery.nice-select.min.js',
  '/js/theme-switching.js',
  '/js/no-internet.js',
  '/js/active.js',
  '/js/pwa.js',
  '/img/bg-img/no-internet.png'

];

// INSTALL: precache everything
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(STATIC_CACHE).then((cache) => {
      return cache.addAll(PRECACHE_ASSETS);
    })
  );
  // activate immediately
  self.skipWaiting();
});

// ACTIVATE: clean old caches
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys
          .filter((key) => key !== STATIC_CACHE && key !== RUNTIME_CACHE)
          .map((key) => caches.delete(key))
      );
    })
  );
  self.clients.claim();
});

// FETCH: cache-first for static, network-first for others
self.addEventListener('fetch', (event) => {
  const req = event.request;
  const url = new URL(req.url);

  // only handle same-origin
  if (url.origin === self.location.origin) {
    // 1) static file pattern
    if (
      url.pathname.startsWith('/css/') ||
      url.pathname.startsWith('/js/') ||
      url.pathname.startsWith('/img/') ||
      url.pathname.startsWith('/fonts/')
    ) {
      // CACHE-FIRST
      event.respondWith(cacheFirst(req));
      return;
    }
  }

  // for everything else, use existing strategy: try cache, then network, then offline
  event.respondWith(networkWithCacheFallback(req));
});

// helpers
async function cacheFirst(request) {
  const cache = await caches.open(STATIC_CACHE);
  const cached = await cache.match(request);
  if (cached) {
    return cached;
  }
  const res = await fetch(request);
  // optional: only cache successful responses
  if (res.ok) {
    cache.put(request, res.clone());
  }
  return res;
}

async function networkWithCacheFallback(request) {
  try {
    const res = await fetch(request);
    const cache = await caches.open(RUNTIME_CACHE);
    cache.put(request, res.clone());
    return res;
  } catch (err) {
    // offline fallback
    const cache = await caches.open(STATIC_CACHE);
    const offline = await cache.match('/offline.html');
    return offline || new Response('Offline', { status: 503 });
  }
}
