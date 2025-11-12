<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#625AFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
    <!-- Title -->
    <title>{{ config('app.title') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap"
        rel="stylesheet">
    <!-- Favicon -->
    
    <link rel="icon" href="img/icons/icon-72x72.png">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        .neo-btn {
            display: inline-block;
            background: #e5e9f0;
            /* light bg – adjust if your page is darker */
            color: #333;
            padding: 10px 10px;
            border-radius: 14px;
            font-weight: 500;
            text-decoration: none;
            box-shadow: 6px 6px 14px rgba(163, 177, 198, 0.6),
                -6px -6px 14px rgba(255, 255, 255, 0.9);
            transition: all 0.15s ease-in-out;
            letter-spacing: 0.01em;
        }

        .neo-btn:hover {
            box-shadow: inset 4px 4px 10px rgba(163, 177, 198, 0.4),
                inset -4px -4px 10px rgba(255, 255, 255, 0.9);
            color: #111;
        }

        .neo-btn:active {
            transform: translateY(1px);
        }
    </style>


</head>

<body>
    <!-- Preloader-->
    <div class="preloader" id="preloader">
        <div class="spinner-grow text-secondary" role="status">
            <div class="sr-only"></div>
        </div>
    </div>

    @include('frontend.components.header');
    @include('frontend.components.sidebar');

    @yield('pages');
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>

    @include('frontend.components.footer');

    <!-- All JavaScript Files-->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.passwordstrength.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/theme-switching.js') }}"></script>
    <script src="{{ asset('js/no-internet.js') }}"></script>
    <script src="{{ asset('js/active.js') }}"></script>
    <script src="{{ asset('js/pwa.js') }}"></script>
    <script>
        $(window).on('load', function() {
            $('.product-carousel').owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                navText: [
                    '<i class="ti ti-chevron-left"></i>',
                    '<i class="ti ti-chevron-right"></i>'
                ]
            });
        });
    </script>

    {{-- <script>
        (function() {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            // Delegate clicks for all .add-to-cart buttons (works for lists, dynamic renders)
            document.addEventListener('click', async (e) => {
                const btn = e.target.closest('.add-to-cart');
                if (!btn) return;

                e.preventDefault();
                if (btn.dataset.loading === '1' || btn.dataset.added === '1') return;

                const url = btn.dataset.url;
                const pid = parseInt(btn.dataset.productId || '0', 10);
                const qty = Math.max(1, parseInt(btn.dataset.qty || '1', 10));
                const color = btn.dataset.color || null;
                const size = btn.dataset.size || null;

                // UI: loading state
                btn.dataset.loading = '1';
                const icon = btn.querySelector('i');
                const originalClass = icon ? icon.className : '';
                if (icon) {
                    icon.className = 'ti ti-loader-2 ti-spin'; // tiny spinner
                }

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: JSON.stringify({
                            product_id: pid,
                            qty: qty,
                            color: color,
                            size: size
                        })
                    });

                    // Try to parse JSON (may throw if not JSON)
                    let data = {};
                    try {
                        data = await res.json();
                    } catch (_) {}

                    if (res.status === 401) {
                        // Not logged in → go to login (your login JSON often includes a "redirect")
                        const redirect = data?.redirect || "{{ route('userlogin') }}";
                        window.location = redirect;
                        return;
                    }

                    if (!res.ok) {
                        const msg = data?.message || 'Failed to add to cart.';
                        throw new Error(msg);
                    }

                    // Success: flip icon to tick, set success styles, lock the button
                    if (icon) icon.className = 'ti ti-check';
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-success');
                    btn.setAttribute('aria-label', 'Added to cart');
                    btn.dataset.added = '1';

                    // Optional: show a toast/snackbar if you have one
                    // showToast(data.message || 'Added to cart');

                } catch (err) {
                    // Restore icon; show an alert (or your toast)
                    if (icon) icon.className = originalClass || 'ti ti-plus';
                    alert(err?.message || 'Something went wrong. Please try again.');
                } finally {
                    btn.dataset.loading = '0';
                }
            });
        })();
    </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', async function(e) {
                const btn = e.target.closest('.neo-btn');
                if (!btn) return;
                e.preventDefault();

                // save original content to restore on error
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.classList.add('opacity-75', 'pointer-events-none'); // optional visual
                btn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';

                const url = btn.dataset.url;
                const id = btn.dataset.productId;
                const qty = btn.dataset.qty || 1;
                const color = btn.dataset.color || '';
                const size = btn.dataset.size || '';

                const token =
                    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    "{{ csrf_token() }}";

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: new URLSearchParams({
                            product_id: id,
                            qty: qty,
                            color: color,
                            size: size
                        })
                    });

                    let data = {};
                    const ct = res.headers.get('content-type') || '';
                    if (ct.includes('application/json')) {
                        data = await res.json();
                    }

                    // CASE 1: JSON success
                    if (data.status === 'success') {
                        window.location.href = "{{ route('checkout') }}";
                        return;
                    }

                    // CASE 2: HTML/redirect response but OK
                    if (res.ok && !ct.includes('application/json')) {
                        window.location.href = "{{ route('checkout') }}";
                        return;
                    }

                    // error from server
                    alert(data.message || 'Something went wrong while adding to cart.');
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'pointer-events-none');
                    btn.innerHTML = originalHtml;

                } catch (err) {
                    console.error(err);
                    alert('Network error.');
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'pointer-events-none');
                    btn.innerHTML = originalHtml;
                }
            });
        });
    </script>

<script>
window.addEventListener('pageshow', function (event) {
    // only refresh when coming back from bfcache
    if (event.persisted) {
        refreshCartUI();
    }
});

function refreshCartUI() {
    fetch("{{ route('cart.show') }}", {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        // update cart count
        const cartCountEl = document.querySelector('.cart-count, #cartCount, [data-cart-count]');
        if (cartCountEl) {
            cartCountEl.textContent = data.count;
        }

        // also reset buy-now buttons so they don't stay "Processing..."
        const btns = document.querySelectorAll('.neo-btn[data-url][data-product-id]');
        btns.forEach(b => {
            b.disabled = false;
            b.classList.remove('is-processing');
            b.textContent = b.dataset.originalText || 'Buy Now';
        });
    })
    .catch(console.error);
}
</script>


    @stack('scripts')

</body>

</html>
