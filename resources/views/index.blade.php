<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Voyagene</title>

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body>

<main id="container" class="h-full bg-gradient-to-br from-gray-800 via-gray-700 to-gray-900 flex flex-row">
    <div class="shrink">
        <livewire:ui.control-panel />
    </div>
    <div class="flex-1 border">
        <livewire:ui.chart />
    </div>

</main>

@livewireScripts
</body>
</html>