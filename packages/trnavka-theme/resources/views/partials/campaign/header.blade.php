@if(!($show_title_inside ?? true))
    <div class="header-title">
        <div class="container-fluid">
            <div class="lead-holder">
                <h1>{{ $header_title ?? 'Daj na to!' }}</h1>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="lead">
                            {!! $header_description ?? 'Tvoj pravidelný dar dá impulz tomu, na&nbsp;čom pracujeme.' !!}
                        </p>

                        @if(isset($dajnato_cta_form_url))
                            <div class="header-dajnato-button">
                                <button type="button" class="btn-donate btn-dajnato-cta" data-form-url="{{ $dajnato_cta_form_url }}">Podporiť</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="header">
    @if($show_title_inside ?? true)
        <div class="container-fluid ">
            <div class="lead-holder">
                <h1>{{ $header_title ?? 'Daj na to!' }}</h1>
                <div class="row">
                    <div class="col-md-6">
                        <p class="lead">
                            {!! $header_description ?? 'Tvoj pravidelný dar dá impulz tomu, na&nbsp;čom pracujeme.' !!}
                        </p>

                        @if(isset($dajnato_cta_form_url))
                            <div class="header-dajnato-button">
                                <button type="button" class="btn-donate btn-dajnato-cta" data-form-url="{{ $dajnato_cta_form_url }}">Podporiť</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
