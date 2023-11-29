<style>
    img {
        width: 100%;
        /*max-width: 100%;*/
        height: auto;
    }
</style>

@php
    $show_only_share = $show_only_share ?? false;
    $show_only_form = $show_only_form ?? false;
	$show_content = !$show_only_share && !$show_only_form;
@endphp

@if($show_content)
    <div @if($campaign->active)class="btn-dajnato-cta" data-form-url="{{ $dajnato_cta_form_url }}"@endif>
        @php(the_post_thumbnail())
    </div>
@endif

<div class="bg-white">
    <div class="detail-page" @if(!$show_content) style="margin-bottom: 0; padding-bottom: 0;"@endif>
        <div class="container-fluid">
            <a class="back-btn" href=".."><span>&larr;</span>späť na Daj na to</a>
            @if($campaign->titleShown || !$show_content)
                <h1>
                        <?php /** @var \App\Entity\Campaign $campaign */ ?>
                    {!! $campaign->title !!}
                </h1>
            @endif

            @if($show_only_form)
                <a href="../{{ $campaign->slug }}/">Zobraziť detaily kampane</a>
            @elseif($show_only_share)
                <div>...</div>
                <script src="{{$share_javascript}}" data-url="{{$campaign_url}}" data-view="current"></script>
                <textarea style='
                    width: 100%;
                    height: 100px;
                    font-family: "Courier New", Courier, monospace;
                    font-size: 15px;
                    line-height: 17px;'><div></div><script src="{{$share_javascript}}" data-url="{{$campaign_url}}" data-view="current"></script></textarea>
            @else
                @php(the_content())
            @endif

            <div class="description">
                @if($show_content)
                    {!! $campaign->content !!}
                @endif

                @if(!$campaign->active)
                    <p class="pt-3">
                        <strong>Táto zbierka je už ukončená. Vyzbieralo sa {!! $campaign->getCurrentAmountFormatted() !!}.</strong>
                    </p>
                    <p class="pt-3">Ak chceš prispieť, tak sa môžeš
                        <a href="..">zapojiť do Daj na to!</a> a podporovať Trnávku pravidelne a dlhodobo.
                    </p>
                @endif
            </div>

            @if($show_content)
                <h2 class="wp-block-heading">Zdroje darov</h2>

                <table class="table table-borderless table-sm mb-5">
                    <tbody>
                        @foreach($campaign->sources['sources'] ?? [] as $sourceName => $sourceValue)
                            <tr>
                                <td class="ps-0">
                                    @if('__self' === $sourceName)
                                        Daj na to! - táto zbierka
                                    @elseif('__fund' === $sourceName)
                                        Daj na to! - štartovací príspevok
                                    @else
                                        {{ $sourceName }}
                                    @endif
                                </td>
                                <td class="pe-0" style="text-align: right">
                                    @euro($sourceValue / 100)
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="p-0">
                                <hr class="mt-2 mb-2"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-0">
                                <em>Spolu</em>
                            </td>
                            <td class="pe-0" style="text-align: right">
                                <em>@euro(($campaign->sources['sum'] ?? 0) / 100)</em>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            @endif

            @if($campaign->active && $show_content)
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
    @if(!$show_only_share)
        <div class="embedded-dajnato-form" id="darovaci-formular">
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
    @endif
</div>

