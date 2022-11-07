<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('includes.head')
    </head>

    <body data-layout="horizontal">
        <div id="wrapper">

            <header id="topnav">
                @include('includes.header')
            </header>

            <div class="content-page">
                @yield('content')

            <footer class="footer">
                @include('includes.footer')
            </footer>
            
            </div>
        </div>
    </body>
</html>
@include('includes.scripts')