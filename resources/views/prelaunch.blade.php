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
            <x-icon-logo class="w-full mb-8 h-14 max-w-44 fill-primary-500" />

            <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 md:text-2xl lg:text-2xl">
                <span class="inline-block">Dragi utilizatori și prieteni ai platformei </span>
                <span class="inline-block text-primary-500">Bursa Binelui,</span>

            </h1>

            <div class="relative flex flex-wrap items-center gap-6 pb-10 my-10">
                <div class="prose">
                    <p>După o perioadă de 10 ani în care am construit împreună multe fapte bune, donații și campionate, avem vești importante despre platforma noastră. Am pregătit o platformă nouă, care să ne ajute să inspirăm comunitățile din jurul nostru.
                        Noua platformă va deveni activă începând din data de 15 mai 2024, când vom avea toate datele migrate.</p>

                    <p>Abia așteptăm să creștem împreună comunitățile pentru proiectele voastre, iar pentru donatori, să oferim o experiență și mai plăcută în a face bine.</p>
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
