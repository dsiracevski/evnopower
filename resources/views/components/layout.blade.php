<!doctype html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVNoPower</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <wireui:scripts />
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body>


    <div class="lg:px-24 px-6 md:py-5 p-4 mx-auto min-h-screen bg-white">

        {{$slot}}

    </div>


    @livewireScripts

</body>
</html>