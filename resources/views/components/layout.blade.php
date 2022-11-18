<!doctype html>
<html lang="mk">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVNoPower</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    <div class="lg:px-24 px-6 md:py-8 p-4 mx-auto min-h-screen bg-white">

        {{$slot}}

        <canvas id="outageChart" height="100px"></canvas>

    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</html>
