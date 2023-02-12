<?php

namespace App\Repositories;

use App\Entity\Campaign;
use App\Metabox\CampaignMetabox;
use WP_Post;
use WP_Query;

class CampaignRepository
{
    public function find(int|WP_Post $postOrId): Campaign|null
    {
        $post = $postOrId instanceof WP_Post ? $postOrId : (new WP_Query([
            'post_type' => 'campaign',
            'p' => $postOrId
        ]))->get_posts()[0] ?? null;

        return null === $post ? null : $this->hydrateEntity($post);
    }

    /**
     * @return Campaign[]
     */
    public function findAllActive(): array
    {
        return $this->findAll('publish');
    }

    /**
     * @return Campaign[]
     */
    public function findAllArchived(): array
    {
        return $this->findAll('archived');
    }

    /**
     * @return Campaign[]
     */
    public function findAll(null | string $status = null): array
    {
        $args = array(
            'post_type' => 'campaign',
            'posts_per_page' => 1000,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        if (null !== $status) {
            $args['post_status'] = $status;
        }

        return collect((new WP_Query($args))->get_posts())
            ->map(fn(WP_Post $post) => $this->hydrateEntity($post))
            ->toArray();
    }

    private function hydrateEntity(WP_Post $post): Campaign
    {
        $data = get_post_meta($post->ID, CampaignMetabox::id(), true);
        $currentAmount = (float)get_post_meta($post->ID, 'dajnato_campaign_current_amount', true);

        if (!is_array($data)) {
            $data = [];
        }

        return (new Campaign())
            ->setID($post->ID)
            ->setTitle($post->post_title)
            ->setSlug($post->post_name)
            ->setDarujmeId($data['darujme_id'] ?? '')
            ->setDarujmeFeedId($data['darujme_feed_id'] ?? '')
            ->setShortDescription($data['short_description'] ?? '')
            ->setContent($data['content'] ?? '')
            ->setOptions([
                (int)($data['option_1'] ?? 10),
                (int)($data['option_2'] ?? 30),
                (int)($data['option_3'] ?? 99),
            ])
            ->setGoalAmount((int)round($data['goal_amount']))
            ->setDajnatoAmount((int)round($data['dajnato_amount'] ?? 0))
            ->setActive($post->post_status === 'publish')
            ->setCurrentAmount((int)round((float)($data['start_amount'] ?? 0) + (float)($currentAmount ?? 0)));
    }
}
