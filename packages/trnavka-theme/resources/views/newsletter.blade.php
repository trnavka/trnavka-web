{{--
  Template Name: Newsletter
--}}

@extends('layouts.app')

@php
    $header_title = 'Sledujte, čo máme nové';
    $header_description = 'V Saleziánskom stredisku Trnávka sa neustále niečo deje. Ak chcete byť v obraze, prihláste sa na odber našich noviniek a my vám budeme pravidelne posielať informácie o dianí u nás.';
    $show_service_links = true;
	$dajnato_cta_title = 'Podporte nás pravidelným finančným darom';
	$dajnato_cta_button = 'Podporiť';
	$show_title_inside = false;
	get_the_excerpt();
@endphp

@section('content')
    @include('partials.campaign.header')

    <div class="footer-newsletter wp-block-template-part" style="padding-left: 25px; padding-right: 25px;">
        <div class="wp-block-saleziani-newsletter-form" style="padding-left: 0; padding-right: 0; display: block;">
            <h3>Prihlásiť sa na odber noviniek</h3>
            <form method="post" action="https://trnavka.ecomailapp.cz/public/subscribe/1/43c2cd496486bcc27217c3e790fb4088?source=web-trnavka-sk" style="padding: 0;">
                <input type="hidden" name="updateExisting" value=1 />
                <input type="email" name="email" placeholder="Vaša emailová adresa" required="required">
                <label class="input-checkbox">
                    <input type="checkbox" name="gdpr" required="required">
                    <span class="label"><span>Súhlasím so spracúvaním osobných údajov <a href="/suhlas-so-spracuvanim-osobnych-udajov/" target="_blank">na účely informovania o aktivitách</a> Saleziánskeho diela na Trnávke</span></span>
                </label>
                <p class="opacity-50">
                    Emaily posielame len občas a hocikedy sa môžete odhlásiť.
                </p>
                <button type="submit" name="submit" style="padding: 1rem 2rem;">Registrovať</button>
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
