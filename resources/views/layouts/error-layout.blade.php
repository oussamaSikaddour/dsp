<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="@settings('theme_color_class')">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ isset($title) ? $title . ' |' : '' }} @settings('app_name')</title>

    <!-- Shared assets -->



<link rel="icon" type="image/x-icon" href="@settings('logo_url')" />


@vite(['resources/css/core/core.css'])


@vite(['resources/js/app.js'])
</head>

<body>


    <main class="container">
        @yield('pageContent')
    </main>

    <x-core.page-loader/>
</body>

</html>
