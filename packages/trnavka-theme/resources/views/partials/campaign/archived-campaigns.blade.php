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
    </div>
</div>

