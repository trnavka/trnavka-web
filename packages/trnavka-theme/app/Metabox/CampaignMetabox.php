<?php

namespace App\Metabox;

class CampaignMetabox extends AbstractMetabox
{
    public function __construct()
    {
        parent::__construct('campaign', 'Daj na to kampaň', [
            'labels' => [
                'name' => _x('Kampane', 'Daj na to campaign pluarl name'),
                'singular_name' => _x('Kampaň', 'Daj na to campaign singular name'),
                'add_new' => _x('Pridať novú kampaň', 'Daj na to campaign add button'),
            ],
            'show_in_rest' => true,
            'supports' => ['title', /*'editor', 'custom-fields'*/],
            'hierarchical' => false,
            'public' => true,
            'has_archive' => false,
            'rewrite' => [
                'slug' => 'dajnato',
                'with_front' => false,
            ],
        ]);
    }

    protected function renderForm(array $meta): void
    {
        ?>
        <div class="form-group">
            <label for="<?php $this->fieldName('goal_amount') ?>">Cieľová suma</label>
            <input type="number" name="<?php $this->fieldName('goal_amount') ?>" id="<?php $this->fieldName('goal_amount') ?>" class="regular-text" value="<?php echo esc_html($meta['goal_amount'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('option_1') ?>">Predvolené sumy</label>
            <label for="<?php $this->fieldName('option_1') ?>" style="display: inline;">1. </label><input type="number" name="<?php $this->fieldName('option_1') ?>" id="<?php $this->fieldName('option_1') ?>" class="short-text" value="<?php echo esc_html($meta['option_1'] ?? 10); ?>">
            <label for="<?php $this->fieldName('option_2') ?>" style="display: inline; padding-left: 20px;">2. </label><input type="number" name="<?php $this->fieldName('option_2') ?>" id="<?php $this->fieldName('option_2') ?>" class="short-text" value="<?php echo esc_html($meta['option_2'] ?? 30); ?>">
            <label for="<?php $this->fieldName('option_3') ?>" style="display: inline; padding-left: 20px;">3. </label><input type="number" name="<?php $this->fieldName('option_3') ?>" id="<?php $this->fieldName('option_3') ?>" class="short-text" value="<?php echo esc_html($meta['option_3'] ?? 99); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('start_amount') ?>">Úvodná suma</label>
            <input type="number" name="<?php $this->fieldName('start_amount') ?>" id="<?php $this->fieldName('start_amount') ?>" class="regular-text" value="<?php echo esc_html($meta['start_amount'] ?? 0); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('dajnato_amount') ?>">Príspevok z Daj na to</label>
            <input type="number" name="<?php $this->fieldName('dajnato_amount') ?>" id="<?php $this->fieldName('dajnato_amount') ?>" class="regular-text" value="<?php echo esc_html($meta['dajnato_amount'] ?? 0); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('darujme_id') ?>">ID kampane na darujme.sk</label>
            <input type="text" name="<?php $this->fieldName('darujme_id') ?>" id="<?php $this->fieldName('darujme_id') ?>" class="regular-text" value="<?php echo esc_html($meta['darujme_id'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('darujme_feed_id') ?>">ID feedu darov na darujme.sk</label>
            <input type="text" name="<?php $this->fieldName('darujme_feed_id') ?>" id="<?php $this->fieldName('darujme_feed_id') ?>" class="regular-text" value="<?php echo esc_html($meta['darujme_feed_id'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('short_description') ?>">Krátky popis</label>
            <textarea name="<?php $this->fieldName('short_description') ?>" id="<?php $this->fieldName('short_description') ?>" style="width: 100%;" rows="5"><?php echo esc_html($meta['short_description'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('content') ?>">Detailný popis</label>
            <?php
            wp_editor($meta['content'] ?? '', 'dajnato_campaign_content_editor', array(
                'wpautop' => true,
                'media_buttons' => false,
                'textarea_name' => $this->fieldNameString('content'),
                'textarea_rows' => 10,
                'teeny' => true
            ));
            ?>
        </div>

        <?php
    }
}
