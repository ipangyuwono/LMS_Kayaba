<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LMS Dashboard')</title>
    <link rel="icon" href="{{ asset('images/kyb-remove.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/profile.js', 'resources/js/sidebar.js'])
    @stack('styles')
</head>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f3f2ec 0%, #e5e4db 100%);
        color: var(--text);
        min-height: 100vh;
    }
</style>

<body>
<div class="flex min-h-screen relative overflow-visible">
    @include('components.sidebar')
    <main
        class="main-content flex-1 p-4 md:p-8 md:ml-[230px] transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] w-full"
        id="mainContent">

        @include('components.header')

        @yield('content')

    </main>
</div>

@include('components.footer')
@include('components.profile-modal')

@stack('scripts')
</body>

</html>
