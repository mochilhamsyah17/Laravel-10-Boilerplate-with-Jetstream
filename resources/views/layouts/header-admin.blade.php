<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CMS Job Portal</title>


    <!-- Global CSS -->
    <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link defer rel="stylesheet" href="{{ asset('assets/css/flowbite.min.css') }}">
    <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon" />


    <style>
        :root {
            --sidebar-width: 250px;
        }

        html,
        body {
            overflow: hidden;
            /* Mencegah scroll saat loading */
            height: 100vh;
            /* Pastikan tinggi penuh */
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 56px;
            background-color: #949494;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar-link {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar-link:hover {
            opacity: 0.8;
            transform: scale(0.98);
        }

        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            padding-left: 16px;
        }

        .sidebar-toggler {
            display: none;
        }

        @media (max-width: 700px) {
            .sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
                padding-top: 84px;
            }

            .main-content,
            .navbar {
                margin-left: 0;
                padding-left: 0;
            }

            .sidebar-toggler {
                display: block;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content.active,
            .navbar.active {
                margin-left: var(--sidebar-width);
            }
        }

        .loader-wrapper {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: #949494;
            display: flex;
            justify-content: center;
            z-index: 99999;
            max-height: 100vh;
        }

        .loader {
            display: inline-block;
            width: 80px;
            height: 80px;
            position: relative;
            top: 50%;
        }

        .loader-inner {
            width: 50px;
            aspect-ratio: 1;
            display: grid;
        }

        .loader-inner::before,
        .loader-inner::after {
            content: "";
            grid-area: 1/1;
            --c: no-repeat radial-gradient(farthest-side, #fff 92%, #0000);
            background: var(--c) 50% 0, var(--c) 50% 100%, var(--c) 100% 50%, var(--c) 0 50%;
            background-size: 12px 12px;
            animation: l12 1s infinite;
        }

        .loader-inner::before {
            margin: 4px;
            filter: hue-rotate(45deg);
            background-size: 8px 8px;
            animation-timing-function: linear
        }

        @keyframes l12 {
            100% {
                transform: rotate(.5turn)
            }
        }
    </style>

    <!-- jQuery & Bootstrap Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(window).on('load', function() {
            setTimeout(function() {
                $('.loader-wrapper').slideUp('slow', function() {
                    $('html, body').css('overflow', 'auto'); // Aktifkan scroll setelah loading selesai
                });
            }, 500);
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggler = document.querySelector('.sidebar-toggler');
            if (sidebarToggler) {
                sidebarToggler.addEventListener('click', function() {
                    document.querySelector('.sidebar').classList.toggle('active');
                    document.querySelector('.main-content').classList.toggle('active');
                    document.querySelector('.navbar').classList.toggle('active');
                });
            }
        });

        function disableSubmitButton(form) {
            const button = form.querySelector('#submitButton');
            button.disabled = true;
            button.textContent = 'Memproses...';
            button.style.opacity = 0.7;
            button.style.cursor = 'not-allowed';
        }
    </script>
</head>

<body>
    <div class="loader-wrapper"><span class="loader"><span class="loader-inner"></span></span></span>
    </div>