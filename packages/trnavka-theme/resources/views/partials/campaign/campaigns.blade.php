<div class="campaigns-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h2>Aktuálne zbierky</h2>
                <p class="description">
                    Okrem dlhodobého pravidelného darcovstva môžeš jednorazovo podporiť aj konkrétne a časovo ohraničené zbierky:
                </p>
            </div>
        </div>
    </div>
</div>

<div class="collections">
    <div class="container-fluid ">
        <div class="row @if(count($active_campaigns) > 3 && count($active_campaigns) % 3 === 2) justify-content-center @endif gy-4">
            <?php /** @var \App\Entity\Campaign $campaign */ ?>
            @foreach($active_campaigns as $campaign)
                <div class="col-md-6 col-lg-4">
                    <div class="collection-card">
                        <div class="card-description">
                            <h4>{{ $campaign->title }}</h4>
                            <p>{!! $campaign->shortDescription !!}</p>
                        </div>
                        <div class="card-actions">
                            @if($campaign->dajnatoAmount > 0)
                                <div class="dajnato-amount">
                                    Vďaka pravidelným darcom mohlo DAJ NA TO! prispieť na túto zbierku sumou {!! $campaign->getDajnatoAmountFormatted() !!}.
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

<div class="campaigns-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h2>Ukončené zbierky</h2>
                <p class="description">

                </p>
            </div>
        </div>
    </div>
</div>

<div class="collections">
    <div class="container-fluid ">
        <div class="row @if(count($archived_campaigns) > 3 && count($archived_campaigns) % 3 === 2) justify-content-center @endif gy-4">
            <?php /** @var \App\Entity\Campaign $campaign */ ?>
            @foreach($archived_campaigns as $campaign)
                <div class="col-md-6 col-lg-4">
                    <div class="collection-card collection-archived">
                        <div class="card-description">
                            <h4>{{ $campaign->title }}</h4>
                            <p>{!! $campaign->shortDescription !!}</p>
                            <p class="pt-3"><strong>Vyzbieralo sa {!! $campaign->getCurrentAmountFormatted() !!}.</strong></p>
                        </div>
                        <div class="card-actions">
                            <a href="{{ $campaign->slug }}/" class="card-link stretched-link">Viac informácií</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="thank-you">
            <div>Ďakujeme</div>
        </div>
    </div>
</div>

