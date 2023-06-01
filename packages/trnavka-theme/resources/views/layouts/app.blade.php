{{--<a class="sr-only focus:not-sr-only" href="#main">--}}
{{--  {{ __('Skip to content') }}--}}
{{--</a>--}}

@include('sections.header')

<div class="modal" tabindex="-1" id="dajnato-cta-modal">
    <div class="modal-dialog">
        <div class="d-none js-darujme-form-holder"></div>
        <div class="modal-content donation-form js-donation-form">
            <div class="modal-header">
                <h5 class="modal-title">Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                Body
            </div>
            <div class="modal-footer justify-content-center">
               Footer
            </div>
        </div>

    </div>
</div>

@yield('content')

{{--  @hasSection('sidebar')--}}
{{--    <aside class="sidebar">--}}
{{--      @yield('sidebar')--}}
{{--    </aside>--}}
{{--  @endif--}}

@include('sections.footer')
