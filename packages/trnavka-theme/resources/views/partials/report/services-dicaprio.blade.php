@php

    $services = [
        [
            'icon' => 'church.svg',
            'title' => 'Farnosť',
            'image' => '01-farnost.jpg',
            'content' => '<ul>
                <li><strong>111</strong> prvoprijímajúcich + birmovancov</li>
                <li><strong>34</strong> animátorov pripravujúcich deti a mladých na sviatosti</li>
                <li><strong>890</strong> svätých omší</li>
                <!--<li><strong>1000+</strong> spovedí a duchovných rozhovorov</li>-->
            </ul>',
            'links' => [['/farske-oznamy/', 'Farské oznamy'], ['/informacie/', 'Bohoslužby a spovedanie']]
        ],
        [
            'icon' => 'soccer.svg',
            'image' => '02-futbalovy-klub.jpg',
            'title' => 'Futbalový klub',
            'content' => '<ul>
                <li><strong>851</strong> detí na letných kempoch a sústredeniach</li>
                <li><strong>550</strong> hráčov od 6 do 19 rokov</li>
                <li><strong>72</strong> trénerov a dobrovoľníkov</li>
                <!--<li><strong>547</strong> ligových zápasov</li>-->
            </ul>',
            'links' => [['https://sdmdomino.sk/', 'sdmdomino.sk']]
        ],
        [
            'icon' => 'oratko.svg',
            'image' => '03-oratko.jpg',
            'title' => 'Oratko',
            'content' => '<ul>
                <li><strong>440</strong> detí na letných táboroch</li>
                <li><strong>120</strong> animátorov</li>
                <li><strong>1060</strong> stretiek detí a mladých</li>
                <!--<li><strong>1&nbsp;000&nbsp;000</strong> zážitkov</li>-->
            </ul>',
            'links' => [['/oratko/', 'Viac informácií']]
        ],
        [
            'icon' => 'family-garden.svg',
            'title' => 'Rodinná poradňa',
            'image' => '04-rodinna-poradna.jpg',
            'content' => '<ul>
                <li><strong>320</strong> účastníkov vzdelávaní</li>
                <li><strong>184</strong> stretnutí s pármi či jednotlivcami</li>
                <li><strong>13</strong> kurzov a workshopov</li>
            </ul>',
            'links' => [['https://familygarden.sk/', 'familygarden.sk']]
        ],
        [
            'icon' => 'materske-centrum.svg',
            'image' => '05-materske-centrum.jpg',
            'title' => 'Materské centrum',
            'content' => '<ul>
                <li><strong>100+</strong> rodiniek s deťmi navštívilo materské centrum a rôzne akcie materského centra</li>
            </ul>',
            'links' => [
                ['https://www.facebook.com/MCMargaretka', 'Facebook MC Margarétka']
            ]
       ],
       [
            'icon' => 'skolka.svg',
            'image' => '06-skolka.jpg',
            'title' => 'Škôlka',
            'content' => '<ul>
                <li><strong>55</strong> detí v troch triedach</li>
                <li><strong>13</strong> učiteliek a ďalšieho personálu</li>
            </ul>',
            'links' => [
                ['https://msmamymargity.sk/', 'msmamymargity.sk']
            ]
       ],
       [
		   'icon' => 'skauti.svg',
		   'image' => '07-skauti.jpg',
		   'title' => 'Skauti',
		   'content' => '<ul>
                <li><strong>110</strong> detí a mladých na letnom tábore</li>
                <li><strong>25</strong> animátorov (radcov + vodcov)</li>
                <li><strong>300</strong> stretiek (družinoviek)</li>
                <!--<li><strong>1000</strong> osobonocí strávených v lone prírody</li>-->
            </ul>',
		   'links' => [
			   ['https://34zbor.sk/', '34zbor.sk']
           ]
       ],
       [
          'icon' => 'field.svg',
          'image' => '08-ihrisko-a-draha.jpg',
          'title' => 'Futbalové ihrisko a bežecká dráha',
          'content' => '<ul>
                <li><strong>500+</strong> detí a dospelých využili ihrisko a dráhu v čase, keď tam netrénoval futbalový klub</li>
            </ul>',
            'links' => [

            ]
       ] ,
       [
          'icon' => 'doctors.svg',
          'title' => 'Zdravotné stredisko',
          'image' => '09-zdravotne-stredisko.jpg',
          'content' => '<ul>
                <li><strong>17</strong> lekárov</li>
                <li><strong>8</strong> ambulancíí</li>
            </ul>',
            'links' => [
                ['/zdravotne_stredisko_lekaren/', 'Viac informácií']
            ]
       ]
    ];

@endphp

<div class="report-features-dicaprio">
    <div class="container-fluid ">
        <div class="row">
            @foreach($services as $i => $service)
                <div class="col-12">
                <div class="row report-features-item">
                    <div class="col-lg-8 item-image @if(($i + 1) % 2 === 0) order-lg-last
@endif">
                        @if(isset($service['image']))
                            <img src="@asset('images/2023/' . $service['image'])"/>
                        @endif
                    </div>
                    <div class="col-lg-4 d-flex align-self-center">
                        <div class="content @if(($i + 1) % 2 === 0)
                        content-left
                    @else
                        content-right
                    @endif">
                            {{--                    <div class="wp-block-saleziani-icon">--}}
                            {{--                        <div>--}}
                            {{--                            <img src="@asset('images/' . $service['icon'])" alt="">--}}
                            {{--                        </div>--}}
                            {{--                    </div>--}}
                            <h3 class="wp-block-heading mb-4">{{$service['title']}}</h3>
                            <div class="service-content">{!! $service['content'] !!}</div>

                        </div>
                    </div>
                </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
