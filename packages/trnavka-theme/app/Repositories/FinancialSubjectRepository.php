<?php

namespace App\Repositories;

use App\Entity\Campaign;
use App\Entity\FinancialSubject;
use App\Metabox\CampaignMetabox;
use App\Metabox\FinancialSubjectMetabox;
use WP_Post;
use WP_Query;

class FinancialSubjectRepository
{
    /**
     * @return FinancialSubject[]
     */
    public function findAll(): array
    {
        $args = array(
            'post_type' => 'financial_subject',
            'post_status' => 'publish',
            'posts_per_page' => 1000,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        );

        return collect((new WP_Query($args))->get_posts())
            ->map(fn(WP_Post $post) => $this->hydrateEntity($post))
            ->toArray();
    }

    private function hydrateEntity(WP_Post $post): FinancialSubject
    {
        $data = get_post_meta($post->ID, FinancialSubjectMetabox::id(), true);

        if (!is_array($data)) {
            $data = [];
        }

        return (new FinancialSubject())
            ->setID($post->ID)
            ->setTitle($post->post_title)
            ->setSlug($post->post_name)
            ->setIncomeServiceFees((int)($data['income_service_fees'] ?? 0))
            ->setIncomeCollections((int)($data['income_collections'] ?? 0))
            ->setIncomeParishCollections((int)($data['income_parish_collections'] ?? 0))
            ->setIncomeGrants((int)($data['income_grants'] ?? 0))
            ->setIncome2percents((int)($data['income_2percents'] ?? 0))
            ->setCostsUtility((int)($data['costs_utility'] ?? 0))
            ->setCostsMaterial((int)($data['costs_material'] ?? 0))
            ->setCostsMaintenance((int)($data['costs_maintenance'] ?? 0))
            ->setCostsHr((int)($data['costs_hr'] ?? 0))
            ->setCostsFees((int)($data['costs_fees'] ?? 0))
            ->setCostsOther((int)($data['costs_other'] ?? 0))
            ->setDescription(($data['description'] ?? ''));
    }
}
