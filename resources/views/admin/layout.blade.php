<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - E-Commerce Admin</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- jQuery + Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        /* ====== SIDEBAR BASE ====== */
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background: #1f2937;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 1rem;
            background: #111827;
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.2rem;
            margin: 0;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
        }

        .nav-item {
            color: #cbd5e1;
            padding: 1rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.2s;
        }

        .nav-item:hover,
        .nav-item.active {
            background: #374151;
            color: white;
        }

        /* ====== MAIN CONTENT ====== */
        main {
            flex: 1;
            padding: 1rem;
            background: #f3f4f6;
        }

        /* ====== HAMBURGER MENU ====== */
        .hamburger {
            display: none;
            font-size: 1.5rem;
            color: #111827;
            cursor: pointer;
            padding: 1rem;
            background: #f3f4f6;
            border-bottom: 1px solid #e5e7eb;
        }

        /* ====== RESPONSIVE BEHAVIOR ====== */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .hamburger {
                display: block;
            }

            main {
                margin-top: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
            }

            .overlay.active {
                display: block;
            }
        }
    </style>
</head>

<body>
    <!-- Hamburger menu (mobile only) -->
    <div class="hamburger">
        <i class="fas fa-bars"></i>
    </div>

    <x-admin-sidebar />

    <div class="overlay"></div>

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js')}}"></script>
    <script>
        $(document).ready(function () {
            const sidebar = $('.sidebar');
            const overlay = $('.overlay');

            $('.hamburger').click(function () {
                sidebar.toggleClass('active');
                overlay.toggleClass('active');
            });

            overlay.click(function () {
                sidebar.removeClass('active');
                overlay.removeClass('active');
            });
        });
    </script>
</body>
</html>
