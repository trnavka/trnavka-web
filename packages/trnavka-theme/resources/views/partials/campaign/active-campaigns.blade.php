<div class="campaigns-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-5">Aktuálne zbierky</h2>
            </div>
        </div>
    </div>
</div>

<div class="collections">
    <div class="container-fluid ">
        <div class="row @if(count($active_campaigns) > 2 && (count($active_campaigns) + 1) % 3 === 2) justify-content-center @endif gy-4">
            @if(isset($dajnato_cta_form_url))
                <div class="col-md-6 col-lg-4">
                    <div class="collection-card" style="background-color: #e4e4e4;">
                        <div class="card-description">
                            <h4>Saleziánske dielo na Trnávke</h4>
                            <p>
                                Pravidelné finančné dary pre celé Saleziánske dielo na Trnávke sú určené na vytváranie grantového fondu, z ktorého sa
                                poskytuje štartovací príspevok pre zbierky na konkrétne projekty.
                            </p>
                            <p class="mt-2">
                                Takto môžeš pomôcť udržať a rozvíjať športové, kultúrne, sociálne a duchovné aktivity pre deti, mladých, rodičov aj seniorov.
                            </p>
                        </div>
                        <div class="card-actions">
                            <button class="btn-donate btn-dajnato-cta stretched-link" data-form-url="{{$dajnato_cta_form_url}}">Chcem pravidelne podporiť</button>
                        </div>
                    </div>
                </div>
            @endif
            <?php /** @var \App\Entity\Campaign $campaign */ ?>
            @foreach($active_campaigns as $campaign)
                <div class="col-md-6 col-lg-4">
                    <div class="collection-card">
                        <div class="card-description">
                            <h4>{{ $campaign->title }}</h4>
                            <p>{!! $campaign->shortDescription !!}</p>
                        </div>
                        <div class="card-actions">
                            @if($campaign->sources['__fund'] > 0)
                                <div class="dajnato-amount">
                                    Z grantového fondu Daj na to!, ktorý tvoria pravidelní darcovia, bola na túto zbierku poskytnutý štartovací príspevok {!! $campaign->getDajnatoAmountFormatted() !!}.
                                </div>
                            @endif
                            <div class="collection-progress">
                                <div class="collection-progress-bar">
                                    <span class="done" style="width: {{ round(min(1, $campaign->currentAmount / $campaign->goalAmount) * 100, 4)  }}%"></span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="label">Aktuálny stav</div>
                                        <div class="price price-orange">{!! $campaign->getCurrentAmountFormatted() !!} </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <div class="label">Cieľová suma</div>
                                        <div class="price">{!! $campaign->getGoalAmountFormatted() !!}</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ $campaign->slug }}/" class="card-link stretched-link">Viac informácií</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

