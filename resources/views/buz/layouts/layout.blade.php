<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KILIMO BUZ</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(90deg, #348a21 0%, #36b91b 100%);
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .featured-gradient {
            background: linear-gradient(to right, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.7));
        }
        header {
            background-color: #348a21;
        }
        .slider-container {
            overflow: hidden;
        }
        button {
            cursor: pointer;
        }
        .logo {
            height: 71px;
            width: 103px;
            border-radius: 20px;
        }
        .footer-logo {
            height: 140px;
            width: 140px;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('buz.layouts.header')

    @yield('content')

    @include('buz.layouts.footer')

    @yield('scripts')
</body>
</html>
