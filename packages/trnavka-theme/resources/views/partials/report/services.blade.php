@php

    $services = [
        [
            'icon' => 'church.svg',
            'title' => 'Farnosť',
            'content' => '<ul>
                <li><strong>720</strong> svätých omší</li>
                <li><strong>60</strong> birmovancov</li>
                <li><strong>115</strong> prvopríjmajúcich</li>
                <li><strong>89</strong> krstov</li>
                <li><strong>19</strong> sobášov</li>
                <li><strong>28</strong> pohrebov</li>
                <li><strong>2</strong> púte</li>
                <li><strong>tisíce</strong> spovedí a duchovných rozhovorov</li>
            </ul>',
            'links' => [['/farske-oznamy/', 'Farské oznamy'], ['/informacie/', 'Bohoslužby a spovedanie']]
        ],
        [
            'icon' => 'soccer.svg',
            'title' => 'Futbalový klub',
            'content' => '<ul>
                <li><strong>550</strong> hráčov od 6 do 19 rokov</li>
                <li><strong>431</strong> detí na letných futbalových kempoch</li>
                <li><strong>420</strong> hráčov na letných futbalových sústredeniach</li>
                <li><strong>72</strong> trénerov a dobrovoľníkov</li>
                <li><strong>547</strong> zápasov</li>
                <li><strong>2700</strong> tréningových jednotiek</li>
            </ul>',
            'links' => [['https://sdmdomino.sk/', 'sdmdomino.sk']]
        ],
        [
            'icon' => 'oratko.svg',
            'title' => 'Oratko',
            'content' => '<ul>
                <li><strong>440</strong> detí a mladých na letných táboroch</li>
                <li><strong>120</strong> animátorov</li>
                <li><strong>25</strong> stretiek rovesníckych skupín detí a mladých</li>
                <li><strong>4</strong> krúžky (šach, rubikova kocka, ping pong, spoločenské hry)</li>
                <li><strong>stovky</strong> hodín prípravy rôznych aktivít a akcií</li>
            </ul>',
            'links' => [['/oratko/', 'Viac informácií']]
        ],
        [
            'icon' => 'family-garden.svg',
            'title' => 'Rodinná poradňa',
            'content' => '<ul>
                <li><strong>320</strong> účastníkov vzdelávaní</li>
                <li><strong>184</strong> stretnutí s pármi či jednotlivcami</li>
                <li><strong>13</strong> vzdelávacích kurzov a workshopov</li>
            </ul>',
            'links' => [['https://familygarden.sk/', 'familygarden.sk']]
        ],
        [
            'icon' => 'materske-centrum.svg',
            'title' => 'Materské centrum',
            'content' => '<ul>
                <li><strong>265</strong> mám s deťmi navštívilo materské centrum</li>
                <li><strong>43</strong> akcií pre deti a mamy</li>
                <li><strong>8</strong> mamaomší</li>
            </ul>',
            'links' => [
                ['https://www.facebook.com/MCMargaretka', 'Facebook MC Margarétka']
            ]
       ],
       [
            'icon' => 'skolka.svg',
            'title' => 'Škôlka',
            'content' => '<ul>
                <li><strong>8</strong> učiteliek</li>
                <li><strong>115</strong> detí</li>
            </ul>',
            'links' => [
                ['https://msmamymargity.sk/', 'msmamymargity.sk']
            ]
       ],
       [
		   'icon' => 'skauti.svg',
		   'title' => 'Skauti',
		   'content' => '<ul>
                <li><strong>300</strong> družinoviek</li>
                <li><strong>95</strong> detí a mladých na letnom tábore</li>
                <li><strong>20</strong> animátorov</li>
                <li><strong>6</strong> stretiek každý týždeň cez školský rok</li>
            </ul>',
		   'links' => [
			   ['https://34zbor.sk/', '34zbor.sk']
           ]
       ],
       [
          'icon' => 'field.svg',
          'title' => 'Futbalové ihrisko a bežecká dráha',
          'content' => '<ul>
                <li><strong>stovky</strong> deti a dospelých využili ihrisko a dráhu v čase, keď tam netrénoval futbalový klub</li>
            </ul>',
            'links' => [

            ]
       ] ,
       [
          'icon' => 'doctors.svg',
          'title' => 'Zdravotné stredisko',
          'content' => '<ul>
                <li><strong>9</strong> ambulancíí</li>
                <li><strong>25</strong> lekárov a zdravotníckych pracovníkov</li>
            </ul>',
            'links' => [
                ['/zdravotne_stredisko_lekaren/', 'Viac informácií']
            ]
       ]
    ];

@endphp

<div class="report-features">
    <div class="container-fluid ">
        <div class="content">
            <div class="bootstrap-columns-container bootstrap-icon-columns">
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-4">
                            <div class="bootstrap-column-inner ">
                                <div class="wp-block-saleziani-icon">
                                    <div>
                                        <img src="@asset('images/' . $service['icon'])" alt="">
                                    </div>
                                </div>
                                <h3 class="wp-block-heading">{{$service['title']}}</h3>
                                <div class="service-content">{!! $service['content'] !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
