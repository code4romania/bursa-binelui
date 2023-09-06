<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia

    <div class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none z-120 sm:items-start sm:p-6">
        <div id="notification-teleport-target" class="flex flex-col items-center w-full space-y-4 sm:items-end"></div>
    </div>
</body>

</html>
