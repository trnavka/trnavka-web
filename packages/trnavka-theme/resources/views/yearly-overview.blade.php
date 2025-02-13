{{--
  Template Name: Prehľad roka
--}}

@extends('layouts.app')

@php
    $titleHead = (null === $selectedService ? 'v Saleziánskom diele na Trnávke' : $selectedService['title_main']);
    $description = (null === $selectedService ? 'v Saleziánskom diele na Trnávke' : $selectedService['title_description']);
@endphp

@section('content')
    <div class="header-title">
        <div class="container-fluid">
            <div class="lead-holder">
                <h1>Rok {{$year}}</h1>
                <div class="timeline-service-picker mb-5">
                    <h2>
                        {!! $titleHead !!}
                        <span class="timeline-service-picker-header-suffix"> <span class="timeline-chevron"><svg xmlns="http://www.w3.org/2000/svg" height="48px" viewBox="0 -960 960 960" width="48px" fill="#cf3942"><path d="m480-346.5-237-237 41.5-41L480-429l195.5-195.5 41.5 41-237 237Z"/></svg></span></span>
                    </h2>

                    @if(null !== $selectedService)
                        <span class="timeline-show-all"><a href=".">zobraziť za celé dielo</a></span>
                    @endif

                    <div class="timeline-services">
                        <p>
                            Zobraziť aktivity za:
                        </p>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href=".">Celé dielo na Trnávke</a>
                            </li>
                            @foreach($allServices as $service)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="?sluzba={{$service['id']}}">{{$service['title']}}</a>
                                    @if(isset($service['event_count']))<span class="badge bg-primary rounded-pill">{{$service['event_count']}}</span>@endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <p class="lead">
                            Každý rok sa {!! $description !!} deje množstvo aktivít, ktoré spolu so saleziánmi pripravuje veľa ľudí.
                            Pozrite si, čo sa u nás dialo v roku {{$year}}.
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

    @include('partials.report.events')


    <div class="collections">
        <div class="thank-you">
            <div>Ďakujeme</div>
            <p>
                Tešíme sa na spoločné prežitie ďalšieho roka.
            </p>
        </div>
    </div>


    @include('partials.newsletter')

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
