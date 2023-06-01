<style>
    img {
        width: 100%;
        /*max-width: 100%;*/
        height: auto;
    }
</style>

<div @if($campaign->active)class="btn-dajnato-cta" data-form-url="{{ $dajnato_cta_form_url }}"@endif>
    @php(the_post_thumbnail())
</div>

<div class="bg-white">
    <div class="detail-page">
        <div class="container-fluid">
            <a class="back-btn" href=".."><span>&larr;</span>späť na Daj na to</a>
            @if($campaign->titleShown)
                <h1>
                        <?php /** @var \App\Entity\Campaign $campaign */ ?>
                    {!! $campaign->title !!}
                </h1>
            @endif

            @php(the_content())

            <div class="description">
                {!! $campaign->content  !!}

                @if(!$campaign->active)
                    <p class="pt-3">
                        <strong>Táto zbierka je už ukončená. Vyzbieralo sa {!! $campaign->getCurrentAmountFormatted() !!}.</strong>
                    </p>
                    <p class="pt-3">Ak chceš prispieť, tak sa môžeš
                        <a href="..">zapojiť do Daj na to!</a> a podporovať Trnávku pravidelne a dlhodobo.</p>
                @endif
            </div>

            @if($campaign->active)
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
            @endif
        </div>
    </div>
    <div class="embedded-dajnato-form">
        <div class="container-fluid">
            @if($campaign->active)
                <div class="embedded-dajnato-form-holder">
                    {!! $form !!}
                </div>
            @endif
        </div>

        <div class="container-fluid">
            <div class="thank-you">
                <div>Ďakujeme</div>
            </div>
        </div>
    </div>
</div>

