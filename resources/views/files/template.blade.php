<!DOCTYPE html>
<html lang="en">
    <head>
        @include('files.head')
    </head>
    <body>
        {{-- @include('partials.nav') --}}
        @include('files.header')
        @yield('content')
        @include('files.newsletter')
        @include('files.footer')
        @include('files.scripts')
        @yield('scripts')
    </body>
</html>

