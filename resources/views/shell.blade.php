<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME', "BIMS") }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.maptiler.com/maptiler-sdk-js/v3.0.1/maptiler-sdk.umd.min.js"></script>
    <link href="https://cdn.maptiler.com/maptiler-sdk-js/v3.0.1/maptiler-sdk.css" rel="stylesheet" />
    <script src="https://cdn.maptiler.com/leaflet-maptilersdk/v4.0.2/leaflet-maptilersdk.umd.min.js"></script>

</head>

<body>
    @yield('content')

    @stack('scripts')
</body>

</html>