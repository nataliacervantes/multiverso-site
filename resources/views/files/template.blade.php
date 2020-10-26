<!DOCTYPE html>
<html lang="en">
    <head>
        @include('files.head')
    </head>
    <body>
        @yield('popup')
        @include('files.header')
        @yield('content')
        @include('files.newsletter')
        @include('files.footer')
        @include('files.scripts')
        @yield('scripts')
    </body>
</html>

