<?php

namespace App\Metabox;

class CampaignMetabox extends AbstractMetabox
{
    public function __construct()
    {
        parent::__construct('campaign', 'Daj na to kampaň', [], [
            'labels' => [
                'name' => _x('Kampane', 'Daj na to campaign pluarl name'),
                'singular_name' => _x('Kampaň', 'Daj na to campaign singular name'),
                'add_new' => _x('Pridať novú kampaň', 'Daj na to campaign add button'),
            ],
            'show_in_rest' => true,
            'supports' => ['title', 'editor', /*'custom-fields', */ 'thumbnail'],
            'hierarchical' => false,
            'public' => true,
            'has_archive' => false,
            'rewrite' => [
                'slug' => 'dajnato',
                'with_front' => false,
            ],
        ]);
    }

    protected function formToModelData(array $postData): array
    {
        // add checkbox data manually if they are not present (because HTTP POST does not include value of unchecked checkboxes)
        $postData['published'] = $postData['published'] ?? 'F';
        $postData['title_shown'] = $postData['title_shown'] ?? 'F';

        return parent::formToModelData($postData);
    }

    protected function renderForm(array $meta): void
    {
        ?>
        <div class="form-group">
            <input type="checkbox" name="<?php $this->fieldName('published') ?>" id="<?php $this->fieldName('published') ?>" value="T"<?php echo ('T' === ($meta['published'] ?? 'F')) ? ' checked' : ''; ?>>
            <label for="<?php $this->fieldName('published') ?>" style="display: inline-block;">Zverejnená v zozname kampaní</label>
        </div>
        <div class="form-group">
            <input type="checkbox" name="<?php $this->fieldName('title_shown') ?>" id="<?php $this->fieldName('title_shown') ?>" value="T"<?php echo ('T' === ($meta['title_shown'] ?? 'T')) ? ' checked' : ''; ?>>
            <label for="<?php $this->fieldName('title_shown') ?>" style="display: inline-block;">Zobraziť nadpis</label>
        </div>
        <div class="form-group">
            <label for="<?php $this->fieldName('goal_amount') ?>">Cieľová suma</label>
            <input type="number" name="<?php $this->fieldName('goal_amount') ?>" id="<?php $this->fieldName('goal_amount') ?>" class="regular-text" value="<?php echo esc_html($meta['goal_amount'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('option_1') ?>">Predvolené sumy (jednorazové)</label>
            <div>
                <small>Ak sú všetky sumy prázdne, tak nebude možné nastaviť jednorazovú platbu</small>
            </div>
            <label for="<?php $this->fieldName('option_1') ?>" style="display: inline;">1. </label><input type="number" name="<?php $this->fieldName('option_1') ?>" id="<?php $this->fieldName('option_1') ?>" class="short-text" value="<?php echo esc_html($meta['option_1'] ?? 99); ?>">
            <label for="<?php $this->fieldName('option_2') ?>" style="display: inline; padding-left: 20px;">2. </label><input type="number" name="<?php $this->fieldName('option_2') ?>" id="<?php $this->fieldName('option_2') ?>" class="short-text" value="<?php echo esc_html($meta['option_2'] ?? 30); ?>">
            <label for="<?php $this->fieldName('option_3') ?>" style="display: inline; padding-left: 20px;">3. </label><input type="number" name="<?php $this->fieldName('option_3') ?>" id="<?php $this->fieldName('option_3') ?>" class="short-text" value="<?php echo esc_html($meta['option_3'] ?? 10); ?>">
        </div>

        <div class="form-group">
            <label for="<?php $this->fieldName('recurring_option_1') ?>">Predvolené sumy (pravidelné)</label>
            <div>
                <small>Ak sú všetky sumy prázdne, tak nebude možné nastaviť pravidelnú platbu</small>
            </div>
            <label for="<?php $this->fieldName('recurring_option_1') ?>" style="display: inline;">1. </label><input type="number" name="<?php $this->fieldName('recurring_option_1') ?>" id="<?php $this->fieldName('recurring_option_1') ?>" class="short-text" value="<?php echo esc_html($meta['recurring_option_1'] ?? ''); ?>">
            <label for="<?php $this->fieldName('recurring_option_2') ?>" style="display: inline; padding-left: 20px;">2. </label><input type="number" name="<?php $this->fieldName('recurring_option_2') ?>" id="<?php $this->fieldName('recurring_option_2') ?>" class="short-text" value="<?php echo esc_html($meta['recurring_option_2'] ?? ''); ?>">
            <label for="<?php $this->fieldName('recurring_option_3') ?>" style="display: inline; padding-left: 20px;">3. </label><input type="number" name="<?php $this->fieldName('recurring_option_3') ?>" id="<?php $this->fieldName('recurring_option_3') ?>" class="short-text" value="<?php echo esc_html($meta['recurring_option_3'] ?? ''); ?>">
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
            <label for="<?php $this->fieldName('json_config') ?>">JSON config</label>
            <textarea name="<?php $this->fieldName('json_config') ?>" id="<?php $this->fieldName('json_config') ?>" style="width: 100%;" rows="10"><?php echo esc_html($meta['json_config'] ?? ''); ?></textarea>
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
