<?php

namespace App\Metabox;

class FinancialSubjectMetabox extends AbstractMetabox
{
    public function __construct()
    {
        parent::__construct('financial_subject', 'Finančný subjekt', [
            'labels' => [
                'name' => _x('Finančné subjekty', 'Finančný subjekt plural name'),
                'singular_name' => _x('Finančný subjekt', 'Finančný subjekt singular name'),
                'add_new' => _x('Pridať finančný subjekt', 'Finančný subjekt add button'),
            ],
            'show_in_rest' => true,
            'supports' => ['title', 'page-attributes', /*'editor', 'custom-fields'*/],
            'hierarchical' => false,
            'public' => false,
            'show_ui' => true,
            'has_archive' => false,
        ]);

        add_filter("posts_orderby", function (
            $orderby,
            $query
        ) {
            global $wpdb;

            if ($query->get("post_type") == "financial_subject") {
                return "$wpdb->posts.menu_order ASC";
            }

            return $orderby;
        }, 10, 2);
    }

    protected function renderForm(array $meta): void
    {
        $groups = [
            [
                'title' => 'Príjmy',
                'fields' => [
                    'income_service_fees' => 'Príspevky (členské, poplatky)',
                    'income_collections' => 'Milodary, zbierky',
                    'income_parish_collections' => 'Zvonček',
                    'income_grants' => 'Dotácie',
                    'income_2percents' => '2% z dane',
                ]
            ],
            [
                'title' => 'Výdavky',
                'fields' => [
                    'costs_utility' => 'Energie',
                    'costs_material' => 'Materiál',
                    'costs_maintenance' => 'Opravy',
                    'costs_hr' => 'Personálne náklady',
                    'costs_fees' => 'Poplatky',
                    'costs_other' => 'Ostatné',
                ]
            ]
        ];

        $content = '';

        foreach ($groups as $group) {
            $content .= '<h3>' . $group['title'] . '</h3>';

            foreach ($group['fields'] as $fieldId => $fieldTitle) {
                $content .= '<div class="form-group">';
                $content .= '<label for="' . $this->fieldNameString($fieldId) . '">' . $fieldTitle . '</label>';
                $content .= '<input type="number" name="' . $this->fieldNameString($fieldId) . '" id="' . $this->fieldNameString($fieldId) . '" class="regular-text" value="' . esc_html($meta[$fieldId] ?? '') . '">';
                $content .= '</div>';
            }
        }

        echo $content;
    }
}
