<?php

namespace App\Metabox;

class SmallThumbnailMetabox extends AbstractMetabox
{
    public function __construct()
    {
        parent::__construct('campaign', 'Small featured image', [
            'context' => 'side'
        ]);
    }

    protected function renderForm(array $meta): void
    {
        ?>
        <div style="box-sizing: border-box">
            <button class="components-button is-secondary media-selector" data-input-selector="[name='comedian_meta[image]']">Vybrať</button>
        </div>

        <?php
    }
}
