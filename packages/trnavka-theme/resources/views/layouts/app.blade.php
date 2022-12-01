{{--<a class="sr-only focus:not-sr-only" href="#main">--}}
{{--  {{ __('Skip to content') }}--}}
{{--</a>--}}

@include('sections.header')

  @yield('content')

{{--  @hasSection('sidebar')--}}
{{--    <aside class="sidebar">--}}
{{--      @yield('sidebar')--}}
{{--    </aside>--}}
{{--  @endif--}}

@include('sections.footer')
