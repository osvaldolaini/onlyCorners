@php
    $faviconVersion = null;
    $faviconPath = public_path('storage/logos/favicons/favicon.ico');
    if (file_exists($faviconPath)) {
        $faviconVersion = filemtime($faviconPath);
    } else {
        $faviconVersion = time();
    }
@endphp

<link rel="shortcut icon" href="{{ url('storage/logos/favicons/favicon.ico') }}?v={{ $faviconVersion }}" />
<link rel="apple-touch-icon" sizes="57x57"
    href="{{ url('storage/logos/favicons/apple-icon-57x57.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="60x60"
    href="{{ url('storage/logos/favicons/apple-icon-60x60.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="72x72"
    href="{{ url('storage/logos/favicons/apple-icon-72x72.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="76x76"
    href="{{ url('storage/logos/favicons/apple-icon-76x76.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="114x114"
    href="{{ url('storage/logos/favicons/apple-icon-114x114.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="120x120"
    href="{{ url('storage/logos/favicons/apple-icon-120x120.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="144x144"
    href="{{ url('storage/logos/favicons/apple-icon-144x144.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="152x152"
    href="{{ url('storage/logos/favicons/apple-icon-152x152.png') }}?v={{ $faviconVersion }}">
<link rel="apple-touch-icon" sizes="180x180"
    href="{{ url('storage/logos/favicons/apple-icon-180x180.png') }}?v={{ $faviconVersion }}">
<link rel="icon" type="image/png" sizes="16x16"
    href="{{ url('storage/logos/favicons/favicon-16x16.png') }}?v={{ $faviconVersion }}">
<link rel="icon" type="image/png" sizes="32x32"
    href="{{ url('storage/logos/favicons/favicon-32x32.png') }}?v={{ $faviconVersion }}">
<link rel="icon" type="image/png" sizes="96x96"
    href="{{ url('storage/logos/favicons/favicon-96x96.png') }}?v={{ $faviconVersion }}">
<link rel="icon" type="image/png" sizes="192x192"
    href="{{ url('storage/logos/favicons/android-icon-192x192.png') }}?v={{ $faviconVersion }}">
<link rel="manifest" href="{{ url('favicons/manifest.json') }}?v={{ $faviconVersion }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage"
    content="{{ url('storage/logos/favicons/ms-icon-144x144.png') }}?v={{ $faviconVersion }}">
