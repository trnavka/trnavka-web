{{--
  Template Name: 2023
--}}

@extends('layouts.app')

@section('content')

    <div class="header-title">
        <div class="container-fluid">
            <div class="lead-holder">
                <h1>Rok 2023</h1>
                <div class="row">
                    <div class="col-lg-8">
                        <p class="lead">
                            Každý rok sa v Saleziánskom diele na Trnávke deje množstvo aktivít, ktoré spolu so saleziánmi pripravuje veľa ľudí.
                            Pozrite si, čo sa u nás dialo v roku 2023.
                        </p>
                        <p class="lead text-muted">
                            Ak by ste sa chceli zapojiť aj vy, ozvite sa nám. Hľadáme každého.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.report.services-dicaprio')

    @include('partials.newsletter')

    @include('partials.report.events')

    <div class="collections">
        <div class="thank-you">
            <div>Ďakujeme</div>
            <p>
                Tešíme sa na spoločné prežitie ďalšieho roka.
            </p>
        </div>
    </div>


    @php
        $dajnato_cta_title = 'Podporte nás pravidelným finančným darom';
		$dajnato_cta_button = 'Podporiť';
    @endphp

    <div class="footer">
        @include('partials.campaign.donate-widget')
        <div class="post-content-holder">

            @php the_content() @endphp
        </div>
    </div>
@endsection
