@php
    $dajnato_cta_title = $dajnato_cta_title ?? 'Mesačne budem prispievať do Daj na to!';
	$dajnato_cta_button = $dajnato_cta_button ?? 'Pokračovať';
	$dajnato_cta_has_only_button = $dajnato_cta_has_only_button ?? false;
	$dajnato_cta_button_url = $dajnato_cta_button_url ?? '';
    $dajnato_cta_values = $dajnato_cta_values ?? [
            [
                'value' => 9,
                'selected' => false,
            ],
            [
                'value' => 29,
                'selected' => true,
            ],
            [
                'value' => 99,
                'selected' => false,
            ],
        ];
@endphp

<div class="form-widget">
    <div class="title">{{ $dajnato_cta_title }}</div>

    @if (!empty($dajnato_cta_values) && !$dajnato_cta_has_only_button)
        <div class="prices">
            @foreach($dajnato_cta_values as $value)
                <div class="price-input">
                    <label>
                        <input type="radio" name="{{ $prefix }}price-list-widget" value="{{$value['value']}}" @if($value['selected'])
                            checked
                            @endif class="js-subscription-widget">
                        <span>@euro($value['value'])</span>
                    </label>
                </div>
            @endforeach
        </div>
    @endif
    @if ($dajnato_cta_has_only_button)
        <a href="{{ $dajnato_cta_button_url }}" class="btn-donate btn-dajnato-cta">{{ $dajnato_cta_button }}</a>
    @else
        <button type="button" @if(isset($dajnato_cta_form_url))class="btn-donate btn-dajnato-cta" data-form-url="{{ $dajnato_cta_form_url }}" @else class="btn-donate" data-bs-toggle="modal" data-bs-target="#donationModal"@endif>{{ $dajnato_cta_button }}</button>
    @endif
</div>
