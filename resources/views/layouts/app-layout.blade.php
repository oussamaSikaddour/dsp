<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="@settings('theme_color_class')">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title . ' |' : '' }} @settings('app_name')</title>



    <link rel="icon" type="image/x-icon" href="@settings('logo_url')" />






    @vite(['resources/css/app/app.css'])


    <script src="https://cdn.tiny.cloud/1/oe2xz52b1wiacx1ys8xzk5j31bm7r9xsa7ulmo2jg1ikr64l/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    @vite(['resources/js/app.js'])
</head>


<body>

    <livewire:core.nav.for-desktop :forLandingPage="$forLandingPage ?? false" />
    <x-core.nav.hamburger-button />
    <livewire:core.nav.for-phone :forLandingPage="$forLandingPage ?? false" />
    @canany(['admin-access', 'super-admin-access', 'social-admin-access'])
        <x-core.side-bar.open-btn htmlId="mainMenuPhoneBtn" class="sidebar__toggle__btn--phone" />
    @endcanany
    <livewire:core.sidebar />

    <main class="container">
        @yield('pageContent')
    </main>
    {{-- <livewire:app.footer /> --}}
        <livewire:core.errors-handler />
            <livewire:core.combobox-table-container />
    <livewire:core.toast />
        <x-core.page-loader/>

</body>

</html>
