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

                <p class="pt-3"><strong>Táto zbierka je už ukončená. Vyzbieralo sa {!! $campaign->getCurrentAmountFormatted() !!}.</strong></p>
                <p class="pt-3">Ak chceš prispieť, tak sa môžeš <a href="..">zapojiť do Daj na to!</a> a podporovať Trnávku pravidelne a dlhodobo.</p>
            </div>
        </div>

        <div class="container-fluid">
            <div class="thank-you">
                <div>Ďakujeme</div>
            </div>
        </div>
    </div>
</div>

