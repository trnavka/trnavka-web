<div class="bg-white">
    <div class="detail-page">
        <div class="container-fluid">
            <a class="back-btn" href=".."><span>&larr;</span>späť na Daj na to</a>
            <h1>
                <?php /** @var \App\Entity\Campaign $campaign */ ?>
                {!! $campaign->title !!}
            </h1>

            <div class="description">
                {!! $campaign->content  !!}
            </div>

            @if($campaign->dajnatoAmount > 0)
                <div class="dajnato-amount">
                    Vďaka pravidelným darcom mohlo DAJ NA TO prispieť na túto zbierku sumou {!! $campaign->getDajnatoAmountFormatted() !!}.
                </div>
            @endif

            @if(null !== $campaign->goalAmount)
                <div class="detail-progress">
                    <div class="detail-progress-bar">
                        <span class="done" style="width: {{ round(min(1, $campaign->currentAmount / $campaign->goalAmount) * 100, 4)  }}%"></span>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="label">Aktuálny stav</div>
                            <div class="price price-orange">{!! $campaign->getCurrentAmountFormatted() !!}</div>
                        </div>
                        <div class="col-6 text-end">
                            <div class="label">Cieľová suma</div>
                            <div class="price">{!! $campaign->getGoalAmountFormatted() !!}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div style="margin: 0 auto; max-width: 600px; border: 1px solid #dedede; padding: 40px; border-radius: 5px;">
                {!! $form !!}
            </div>
        </div>

        <div class="container-fluid">
            <div class="thank-you">
                <div>Ďakujeme</div>
            </div>
        </div>
    </div>
</div>

