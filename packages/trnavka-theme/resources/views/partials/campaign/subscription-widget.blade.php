<div class="form-widget">
    <div class="title">Mesačne budem prispievať</div>
    <div class="prices">
        <div class="price-input">
            <label>
                <input type="radio" name="{{ $prefix }}price-list-widget" value="9.9" class="js-subscription-widget">
                <span>9,90 €</span>
            </label>
        </div>
        <div class="price-input">
            <label>
                <input type="radio" name="{{ $prefix }}price-list-widget" checked="checked" value="29.9" class="js-subscription-widget">
                <span>29,90 €</span>
            </label>
        </div>
        <div class="price-input">
            <label>
                <input type="radio" name="{{ $prefix }}price-list-widget" value="199.9" class="js-subscription-widget">
                <span>199,90 €</span>
            </label>
        </div>
    </div>
    <button type="button" class="btn-donate" data-bs-toggle="modal" data-bs-target="#donationModal">Pokračovať</button>
</div>
