const shortly = "shortly-v1"
const assets = [
  "/",
  "assets/js/jquery-3.6.3.min.js",
  "assets/js/clipboard.min.js",
  "assets/js/auth/app.js",
  "assets/js/auth/_csrf.js",
  "assets/js/_webapp.js",
  "assets/js/_web_package.min.js",
  "assets/js/sweetalert2.all.min.js",
  "assets/images/logo/hh-logo.webp",
  "assets/images/logo/mm-logo.webp",
  "assets/images/logo/hh-logo-light.webp",
  "assets/images/thumbnail.webp",
  "assets/images/bg/bg1.webp",
  "assets/images/bg/bg2.webp",
]
self.addEventListener("install", installEvent => {
  installEvent.waitUntil(
    caches.open(shortly).then(cache => {
      cache.addAll(assets)
    })
  )
})

self.addEventListener("fetch", fetchEvent => {
  fetchEvent.respondWith(
    caches.match(fetchEvent.request).then(res => {
      return res || fetch(fetchEvent.request)
    })
  )
})