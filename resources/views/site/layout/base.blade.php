<!DOCTYPE html>
<html lang="ru">
@include('site.layout._partials.head')
<body>
    <div class="page-wrap">
        @include('site.layout._partials.header')
        @include('site.layout._partials.main-nav')
        @yield('content')
        @include('site.layout._partials.footer')
        @include('site.layout._partials.scripts')
        @yield('scripts')
    </div>
</body>
</html>