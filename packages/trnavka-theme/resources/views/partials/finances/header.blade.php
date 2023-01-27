<div class="donate-secstion service-finances-donate">
    <div class="container-fluid ">
        <div class="row">
            <div class="col">
                <h1>{{ $title }}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="donate-section">
                    <h2>Daj na to!</h2>
                    <p>
                        V roku 2022 boli náklady vo výške cca 100 tisíc eur pokryté sponzormi a individuálnymi darcami.
                        Veríme, že postupne dokáže podstatnú časť tejto sumy pokryť Daj na to!.
                    </p>
                    <p>
                        <strong>Je dôležité finančne prispievať pravidelne, aby Saleziánske dielo mohlo fungovať. Ďakujeme.</strong>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#donationModal">Chcem prispieť</a>
                    </p>
                    <div class="collection-progress">
                        <div class="collection-progress-bar">
                            <span class="done" style="width: {{31263 / ($trnavka_financial_subject->getLoss() * -1) * 100}}%"></span>
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
                </div>
            </div>
        </div>
    </div>
</div>
