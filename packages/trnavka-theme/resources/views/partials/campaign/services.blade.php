@php

    $services = [
        [
            'icon' => 'church.svg',
            'title' => 'Farnosť',
            'content' => 'Naša farnosť sa nachádza na okraji mesta v mestskej časti Ružinov. Jej územie tvoria sídliská Trnávka, Ostredky, Mierová kolónia, Štrkovec, Zlaté piesky a Letisko. Spravujú ju saleziáni a patrónom kostola je sv. Ján Bosco.',
            'links' => [['/farske-oznamy/', 'Farské oznamy'], ['/informacie/', 'Bohoslužby a spovedanie']]
        ],
        [
            'icon' => 'soccer.svg',
            'title' => 'Futbalový klub',
            'content' => 'SDM DOMINO je najväčší mládežnícky futbalový klub na Slovensku. Pôsobí v ňom vyše 500 hráčov, 50 trénerov, 1000 rodičov. Tréneri, futbalisti, rodičia a všetci sympatizanti sa snažia budovať spoločne jeden klub.',
            'links' => [['https://sdmdomino.sk/', 'sdmdomino.sk']]
        ],
        [
            'icon' => 'oratko.svg',
            'title' => 'Oratko',
            'content' => 'Oratko vytvára priestor na stretávanie sa rovesníckych skupín pre deti a mládež. Vyrastajú v ňom animátori, ktorí sa vo voľnom čase aktívne venujú deťom. Pripravujú pre nich rôzne zážitkové akcie, výlety a letné tábory.',
            'links' => [['/oratko/', 'Viac informácií']]
        ],
        [
            'icon' => 'family-garden.svg',
            'title' => 'Rodinná poradňa',
            'content' => 'Family Garden je poradenské centrum pre rodiny. V oblasti poradenstva je priestor pre osobné stretnutie s odborníkom. V oblasti prevencie je k dispozícii množstvo prednášok, vzdelávacích kurzov a školení.',
            'links' => [['https://familygarden.sk/', 'familygarden.sk']]
        ],
        [
            'icon' => 'materske-centrum.svg',
            'title' => 'Materské centrum',
            'content' => 'Materské centrum Margarétka rozvíja zručnosti detí predškolského veku, socializuje matky a ženy. Vytvára priestor na stretávanie sa celých rodín a pomáha tak saleziánom venovať sa tým najmenším.',
            'links' => [
                ['https://www.facebook.com/MCMargaretka', 'Facebook MC Margarétka']
            ]
       ],
       [
            'icon' => 'skolka.svg',
            'title' => 'Škôlka',
            'content' => 'Materská škola Mamy Margity je trojtriedna škôlka s celodennou starostlivosťou. Materská škola je súčasťou Rodinného centra a má k dispozícii aj vonkajšie priestory pre pohybové aktivity s deťmi.',
            'links' => [
                ['https://msmamymargity.sk/', 'msmamymargity.sk']
            ]
       ],
       [
		   'icon' => 'skauti.svg',
		   'title' => 'Skauti',
		   'content' => 'Na Trnávke môžete zažiť 1000 osobonocí v lone prírody, 300 družinoviek ročne pre viac ako 140 mladých. Skauting pomáha vytvárať prostredie, kde môže mládež vyrásť v zodpovedných a zrelých dospelých.',
		   'links' => [
			   ['https://34zbor.sk/', '34zbor.sk']
           ]
       ],
       [
          'icon' => 'field.svg',
          'title' => 'Futbalové ihrisko a bežecká dráha',
          'content' => 'Futbalové ihrisko na veľkom umelom trávniku je k dispozícii verejnosti vždy, keď na ňom nie je tréning futbalového klubu. Tvorí ho okrem trávnatej plochy aj bežecká dráha, ktorá z ihriska pokračuje v okolí Rodinného centra.',
            'links' => [

            ]
       ] ,
       [
          'icon' => 'doctors.svg',
          'title' => 'Zdravotné stredisko',
          'content' => 'V zdravotnom stredisku sa nachádza lekáreň, všeobecná ambulancia pre dospelých, pediatrická, gynekologická, psychologická, endokrinologická, zubná a ortopedická ambulancia.',
            'links' => [
                ['/zdravotne_stredisko_lekaren/', 'Viac informácií']
            ]
       ]
    ];

@endphp

<div class="features">
    <div class="container-fluid ">
        <div class="content">
            <div class="row">
                <div class="col-12">
                    <h2 class="wp-block-heading mb-3">Služby</h2>
                </div>
                <div class="col-lg-8">
                    <p class="lead">
                        Vybrať si môžete z množstva rôznorodých aktivít a služieb.
                    </p>
                </div>
            </div>

            <div class="bootstrap-columns-container bootstrap-icon-columns">
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-lg-4 col-md-6">
                            <div class="bootstrap-column-inner ">
                                <div class="wp-block-saleziani-icon">
                                    <div>
                                        <img src="@asset('images/' . $service['icon'])" alt="">
                                    </div>
                                </div>
                                <h3 class="wp-block-heading">{{$service['title']}}</h3>
                                <p>{{$service['content']}}</p>
                                @if(($show_service_links ?? false) && isset($service['links']))
                                    <p class="mt-3">
                                        @foreach($service['links'] as $link)
                                            <a href="{{$link[0]}}"@if(str_starts_with($link[0], 'http')) target="_blank"@endif>{{$link[1]}}</a>
                                        @endforeach
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
