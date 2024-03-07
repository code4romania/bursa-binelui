<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @inertiaHead
    @vite(['resources/css/app.css', 'resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="/images/favicons/safari-pinned-tab.svg" color="#00438a">
    <meta name="msapplication-TileColor" content="#00438a">
    <meta name="theme-color" content="#ffffff">
</head>

<body class="font-sans antialiased">
    @inertia

    <div class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none z-120 sm:items-start sm:p-6">
        <div id="notification-teleport-target" class="flex flex-col items-center w-full space-y-4 sm:items-end"></div>
    </div>
</body>

</html>
