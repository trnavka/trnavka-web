{{--
  Template Name: Kvíz o saleziánoch
--}}

@extends('layouts.app')

@php
    $header_title = 'Poznáme našich saleziánov?';
    $show_service_links = true;
	$dajnato_cta_title = 'Podporte nás pravidelným finančným darom';
	$dajnato_cta_button = 'Podporiť';
	$show_title_inside = false;

    $categories = [
        'jedlo' => [
            'rezne' => ['label' => 'rezne', 'success' => 'rezňoch', 'icon' => 'images/icons/rezen.svg'],
            'kapor' => ['label' => 'kapor', 'success' => 'podkovičkách z kapra', 'icon' => 'images/icons/kapor.svg'],
            'kapustnica' => ['label' => 'kapustnica', 'success' => 'kapustnici', 'icon' => 'images/icons/kapustnica.svg'],
            'losos' => ['label' => 'losos', 'success' => 'lososovi', 'icon' => 'images/icons/losos.svg'],
        ],
        'pitie' => [
            'babikove-hriato' => ['label' => 'Babíkove hriatô', 'success' => 'Babíkovým hriatôm', 'icon' => 'images/icons/babikove-hriato.svg'],
            'coca-cola' => ['label' => 'Coca-Cola', 'success' => 'Coca-Colou', 'icon' => 'images/icons/coca-cola.svg'],
            'domaca-a-pivo' => ['label' => 'domáca a pivo', 'success' => 'domácou a pivom', 'icon' => 'images/icons/domaca-a-pivo.svg'],
            'vino' => ['label' => 'víno', 'success' => 'vínom', 'icon' => 'images/icons/vino.svg'],
            'pivo' => ['label' => 'pivo', 'success' => 'pivom', 'icon' => 'images/icons/pivo.svg'],
        ],
        'praca' => [
            'caka-na-jeziska' => ['label' => 'čaká na Ježiška', 'success' => 'čaká na Ježiška', 'icon' => 'images/icons/caka-na-jeziska.svg'],
            'prestiera-stol' => ['label' => 'prestiera stôl', 'success' => 'prestriera stôl', 'icon' => 'images/icons/prestiera-stol.svg'],
            'stavia-stromcek' => ['label' => 'stavia stromček a umýva jedáleň', 'success' => 'stavia stromček a umýva jedáleň', 'icon' => 'images/icons/stavia-stromcek.svg'],
            'strazi-sviecku' => ['label' => 'stráži Betlehemské svetlo', 'success' => 'stráži Betlehemské svetlo', 'icon' => 'images/icons/strazi-sviecku.svg'],
            'umyva-okna' => ['label' => 'umýva okná', 'success' => 'umýva okná', 'icon' => 'images/icons/umyva-okna.svg'],
            'upratovanie' => ['label' => 'upratuje chodby', 'success' => 'upratuje chodby', 'icon' => 'images/icons/upratovanie.svg'],
            'varenie' => ['label' => 'varí štedrú večeru', 'success' => 'varí štedrú večeru', 'icon' => 'images/icons/varenie.svg'],
        ]
    ];

    $path = $_SERVER['REQUEST_URI'];

    if (str_contains($path, 'jedia')) {
        $category = 'jedlo';
    } elseif (str_contains($path, 'prace')) {
        $category = 'praca';
    } else {
        $category = 'pitie';
    }

    $titles = [
        'jedlo' => 'Čo radi jedia?',
        'pitie' => 'Čo radi pijú?',
        'praca' => 'Ako majú rozdelené práce?',
    ];

    $desctiptions = [
        'jedlo' => 'Viete, aké vianočné jedlo majú najradšej naši saleziáni? Jeden z nich je skvelý kuchár – na Vianoce vždy pripraví každému to, čo mu urobí radosť. Pripravili sme pre vás malý, hravý vianočný kvíz. Skúste spárovať saleziánov s ich obľúbenými jedlami.',
        'pitie' => 'K dobrej štedrej večeri a k voňavým vianočným koláčom neodmysliteľne patrí aj niečo tekuté, voňavé či slávnostné do pohára. Aj medzi našimi saleziánmi sa nájdu „fajnšmekri“, ktorí majú počas Vianoc svoje obľúbené nápoje. Skúsme hádať, kto má čo rád v pohári. Pretože aj dobrý pohárik dodá večeru tú správnu príchuť.',
        'praca' => 'V saleziánskej komunite to počas Vianoc vždy žije. Každý má svoju úlohu, ktorej sa zhostí – presne tak, ako to v rodine býva. A hoci sú ich povinnosti rozdielne, všetky smerujú k jednému: aby boli Vianoce skutočne časom radosti a spoločného času. Vtedy si tak ako aj každá rodina - aj tá saleziánska môže oddýchnuť a vychutnať si chvíľu pohody za štedrovečerným stolom.',
    ];

    $headerDescriptions = [
        'jedlo' => 'Keď niekoho poznáme a máme radi, vieme, čo mu chutí, po čom siahne na štedrovečernom stole a pri čom sa mu rozžiaria oči.',
        'pitie' => 'Keď niekoho poznáme a máme radi, vieme, čo mu chutí, po čom siahne na štedrovečernom stole a pri čom sa mu rozžiaria oči.',
        'praca' => 'Keď niekoho poznáme a máme radi, vieme, čo mu chutí, po čom siahne na štedrovečernom stole a pri čom sa mu rozžiaria oči.',
    ];

    $verbs = [
        'jedlo' => 'si rád pochutí na',
        'pitie' => 'si rád štrngne',
        'praca' => 'na Štedrý deň',
    ];

    $title = $titles[$category];
    $desctiption = $desctiptions[$category];
    $verb = $verbs[$category];
    $answers = $categories[$category];
    $header_description = $headerDescriptions[$category];

    $people = [
        ['name' => 'Radovan “Rusty” Rumanovič', 'image' => 'images/people/rumanovic.png', 'answer' => ['jedlo' => 'rezne', 'praca' => 'stavia-stromcek', 'pitie' => 'domaca-a-pivo']],
        ['name' => 'Peter Bučány', 'image' => 'images/people/bucany.png', 'answer' => ['jedlo' => 'losos', 'praca' => 'varenie', 'pitie' => 'vino']],
        ['name' => 'Ján "Jaňo" Naňo', 'image' => 'images/people/nano.png', 'answer' => ['jedlo' => 'kapustnica', 'praca' => 'prestiera-stol', 'pitie' => 'coca-cola']],
        ['name' => 'Vojtech Zeman', 'image' => 'images/people/zeman.png', 'answer' => ['jedlo' => 'kapor', 'praca' => 'caka-na-jeziska', 'pitie' => 'pivo']],
        ['name' => 'Tibor Reimer', 'image' => 'images/people/reimer.png', 'answer' => ['jedlo' => 'losos', 'praca' => 'upratovanie', 'pitie' => 'vino']],
        ['name' => 'Cyril "Cyro" Slíž', 'image' => 'images/people/sliz.png', 'answer' => ['jedlo' => 'rezne', 'praca' => 'stavia-stromcek', 'pitie' => 'babikove-hriato']],
        ['name' => 'Ladislav Babača', 'image' => 'images/people/babaca.png', 'answer' => ['jedlo' => 'losos', 'praca' => 'umyva-okna', 'pitie' => 'vino']],
        ['name' => 'František Kohút', 'image' => 'images/people/kohut.png', 'answer' => ['jedlo' => 'kapor', 'praca' => 'strazi-sviecku', 'pitie' => 'vino']],
    ];
@endphp

@section('content')
    <div class="header-title px-0">
        <div class="container-fluid">
            <div class="lead-holder pb-0">
                <h1 class="mb-3">{{ $header_title }}</h1>
                <div class="row">
                    <div class="col-lg-8">
                        <p class="lead">
                            {!! $header_description !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid section-header pt-5">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <h2 class="wp-block-heading mb-3">{{$title}}</h2>
                </div>
                <div class="col-lg-8">
                    <p class="lead">
                        {{$desctiption}}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid section-header pt-5 quiz" id="quiz">
        <div class="content">
            @foreach($people as $personIndex => $person)
                <div class="row align-items-center mb-5 pb-md-2 pb-5">
                    <div class="col-12 text-center text-md-start">
                        <div class="person-name mb-3">{{$person['name']}}</div>
                    </div>
                    <div class="col-md-auto col-12 text-center">
                        <img src="@asset($person['image'])" alt="{{$person['name']}}" style="width: 250px"/>
                    </div>
                    <div class="col-md-auto col-12 text-center">
                        <img src="@asset('images/icons/plus.svg')" alt="" style="width: 75px"/>
                    </div>
                    <div class="col-md-auto col-12 d-flex flex-column align-items-center align-items-md-start js-quiz-question">
                        @php
                            $personalAnswerId = $person['answer'][$category];
                            $personalAnswer = $answers[$personalAnswerId];
                        @endphp

                        <div class="js-quiz-answers">
                            @foreach($answers as $answerId => $answer)
                                <label class="d-flex flex-column js-quiz-answer-holder">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="d-flex align-items-center">
                                            <input type="radio" name="answer[{{$personIndex}}]" value="{{$answerId}}" data-answer="{{$personalAnswerId}}" class="js-quiz-answer"/><span class="custom-radio"></span>
                                        </div>
                                        <img src="@asset($answer['icon'])" alt="{{$answer['label']}}" style="width: 42px;"/>
                                        {{$answer['label']}}
                                    </div>
                                    <div class="wrong-answer-box my-2 d-none js-wrong-answer">
                                        Toto nie. ;-) Skús znova.
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <div class="text-center text-md-start d-flsex success-box gap-4 d-none js-correct-answer">
                            <div class="mb-3">
                                <img src="@asset($personalAnswer['icon'])" alt="{{$personalAnswer['label']}}" style="width: 64px;"/>
                            </div>
                            <div>
                                <div class="success-title mb-3">
                                    <strong class="fw-bold">Správne!</strong>
                                </div>
                                <span>{{$person['name']}} {{$verb}} <strong>{{$personalAnswer['success']}}</strong>.</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="donate-form-widget py-5">
    <div class="container-fluid section-header py-5">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <h2 class="wp-block-heading mb-3">Saleziáni potrebujú nové bývanie</h2>
                </div>
                <div class="col-lg-8">
                    <p class="lead">
                        Popri tejto sviatočnej radosti však žijú a slúžia v priestoroch, ktoré roky neprešli obnovou.
                        Práve teraz potrebujú nevyhnutnú opravu. Pomôžte nám urobiť prvý krok –  podporte prípravu projektovej dokumentácie na ich nové, dôstojnejšie priestory.  Aj malý dar dokáže rozsvietiť veľké svetlo.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-4">
                    <a href="/dajnato/rekonstrukcia-zazemia-kostola-a-fary/" class="btn-donate mx-0">Chcem prispieť</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="collections">
        <div class="thank-you">
            <div>Ďakujeme a prajeme pekný advent a Vianoce!</div>
        </div>
    </div>
@endsection
