<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css'])
</head>

<body class="font-sans antialiased">
    <main class="container relative grid items-center min-h-screen lg:gap-10 xl:gap-20 lg:grid-cols-2">
        <div class="py-12">
            <img class="mb-8" src="/images/bursa_binelui_logo.png" alt="Logo Bursa Binelui" />

            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 md:text-5xl lg:text-6xl">
                <span class="inline-block">Coming</span>
                <span class="inline-block text-primary-500">soon</span>
            </h1>

            <div class="relative flex flex-wrap items-center gap-6 pb-10 my-10">
                <div class="prose">
                    <p>
                        Ea occaecat aliquip id qui esse fugiat mollit consequat nostrud velit pariatur. Ipsum labore
                        excepteur
                        sit sit ex proident. Eiusmod cillum fugiat incididunt occaecat aliqua ex fugiat minim nostrud
                        nulla sunt
                        Lorem dolor ad consequat. Quis dolore ad cillum occaecat.
                    </p>
                </div>

                <x-icon-patterns.square-small @class([
                    'absolute top-full -left-16 -z-10',
                    'hidden shrink-0 md:block',
                    'fill-primary-100 w-32 h-32',
                ]) />
            </div>
        </div>

        <x-icon-patterns.hero class="hero lg:block" />

    </main>

</body>

</html>
