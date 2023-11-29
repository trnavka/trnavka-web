<div class="donate-section">
    <div class="container-fluid ">
        <div class="row">
            <div class="col">
                <h2>Prečo začať prispievať?</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="donate-content">
                    <p>
                        TRNÁVKA - saleziánske dielo je saleziánske komunitné centrum, v ktorom stovky ľudí denne trávia zmysluplný čas.
                        Širokú ponuku služieb využívajú ľudia z Trnávky a širšieho okolia, bez ohľadu na ich vierovyznanie. Každý je vítaný.
                        Tvoj pravidelný mesačný príspevok je potrebný pre udržanie a rozvoj športových, kultúrnych, sociálnych a duchovných aktivít pre deti, mladých, rodičov aj seniorov.
                    </p>

                    <p>
                        <strong>Je dôležité finančne prispievať pravidelne, aby Saleziánske dielo mohlo fungovať. Ďakujeme.</strong>
                    </p>
                    <div class="collection-progress">
                        <div class="collection-progress-bar">
                            <span class="done" style="width: {{$subscription_amount / ($trnavka_financial_subject->getLoss() * -1) * 100}}%"></span>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="label">Aktuálny stav Daj na to!</div>
                                <div class="price price-orange">@euro($subscription_amount)</div>
                            </div>
                            <div class="col-6">
                                <div class="label">Koľko potrebujeme</div>
                                <div class="price">@euro($trnavka_financial_subject->getLoss() * -1)</div>
                            </div>
                        </div>
                    </div>
                    @if(!isset($disable_stats_link) || !$disable_stats_link)
                        <div>
{{--                            <a href="{{ get_permalink(get_page_by_path('financny-prehlad')) }}">Zobraziť finančný prehľad</a>--}}
                            <a href="/financny-prehlad">Zobraziť finančný prehľad</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6 subscription-widget-holder">
                @include('blocks.dajnato-cta')
            </div>
        </div>
    </div>
</div>
