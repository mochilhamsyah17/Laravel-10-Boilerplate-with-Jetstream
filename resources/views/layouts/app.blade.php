<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <style>
        .scroll-x-hidden {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            /* Firefox */
        }

        .scroll-x-hidden::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari */
        }
    </style>
    <style>
        .custom-radio .form-check-input {
            width: 20px;
            height: 20px;
            margin-left: auto;
            margin-top: 0.5rem;
            border: 2px solid #000;
        }

        .custom-radio .form-check-input:checked {
            background-color: #000;
            border-color: #000;
        }

        .custom-radio .form-check-input:focus {
            box-shadow: none;
        }
    </style>
</head>

<body>
    <div id="Content-Container" class="position-relative d-flex flex-column w-100 mx-auto min-vh-100 bg-white overflow-hidden" style="max-width: 512px;">
        @yield('content')
    </div>


    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
</body>

</html>