{{--
  Template Name: Homepage
--}}

@extends('layouts.app')

@php
    $header_title = 'Super živá komunita';
    $header_description = 'Saleziánske dielo na Trnávke je komunitné centrum, v ktorom stovky ľudí denne trávia zmysluplný čas. Širokú ponuku služieb využívajú ľudia z Trnávky a širšieho okolia, bez ohľadu na ich vierovyznanie. Každý je vítaný.';
    $show_service_links = true;
	$dajnato_cta_title = 'Podporte nás pravidelným finančným darom';
	$dajnato_cta_button = 'Podporiť';
	$show_title_inside = false;
	get_the_excerpt();
@endphp

@section('content')
    @include('partials.campaign.header')

    <div class="latest-posts">
        <div class="container-fluid section-header">
            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <h2 class="wp-block-heading mb-3">Aktuality</h2>
                    </div>
                    <div class="col-lg-8">
                        <p class="lead">
                            Vyberáme pre vás novinky a správy, o ktoré sa chceme s vami podeliť.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bootstrap-columns-container bootstrap-organization-columns">
                <div class="row">
                    @foreach($latest_posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <div class="bootstrap-column-inner has-light-blue-background-color has-light-blue-background-color">
                                @if(!empty($post['thumbnail_url']))
                                    <figure class="wp-block-image size-full">
                                        <img src="{{$post['thumbnail_url']}}" alt="{{$post['post_title']}}">
                                    </figure>
                                @endif
                                <div class="wp-block-group content is-layout-flow wp-block-group-is-layout-flow">
                                    <div class="wp-block-group text is-layout-flow wp-block-group-is-layout-flow">
                                        <h3 class="wp-block-heading">{{$post['post_title']}}</h3>
                                        <p class="text">{!! $post['excerpt'] !!}</p>
                                    </div>
                                    <p class="link">
                                        <a class="stretched-link" href="/{{$post['post_name']}}">Čítať viac</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="footer-newsletter wp-block-template-part">
        <div class="wp-block-saleziani-newsletter-form">
            <h3>Chcete sledovať, čo máme nové? Pridajte sa do trnávkového newslettra</h3>
            <form method="post" action="https://trnavka.ecomailapp.cz/public/subscribe/1/43c2cd496486bcc27217c3e790fb4088?source=web-trnavka-sk">
                <input type="email" name="email" placeholder="Vaša emailová adresa" required="required">
                <label class="input-checkbox">
                    <input type="checkbox" name="gdpr" required="required">
                    <span class="label"><span>Súhlasím so spracúvaním osobných údajov <a href="/suhlas-so-spracuvanim-osobnych-udajov/" target="_blank">na účely informovania o aktivitách</a> Saleziánskeho diela na Trnávke</span></span>
                </label>
                <p class="opacity-50">
                    Emaily posielame len občas a hocikedy sa môžete odhlásiť.
                </p>
                <button type="submit" name="submit">Registrovať</button>
            </form>
        </div>
    </div>

    @include('partials.campaign.services')

    <div class="footer">
        @include('partials.campaign.donate-widget')
        <div class="post-content-holder">

            @php the_content() @endphp
        </div>
    </div>
@endsection
