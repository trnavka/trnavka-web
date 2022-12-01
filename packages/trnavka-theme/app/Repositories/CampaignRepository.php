<?php

namespace App\Repositories;

use App\Entity\Campaign;
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
    public function findAll(): array
    {
        $args = array(
            'post_type' => 'campaign',
            'post_status' => 'publish',
            'posts_per_page' => 1000,
            'orderby' => 'title',
            'order' => 'ASC',
        );

        return collect((new WP_Query($args))->get_posts())
            ->map(fn(WP_Post $post) => $this->hydrateEntity($post))
            ->toArray();
    }

    private function hydrateEntity(WP_Post $post): Campaign
    {
        $data = get_post_meta($post->ID, 'dajnato_campaign', true);

        if (!is_array($data)) {
            $data = [];
        }

        return (new Campaign())
            ->setTitle($post->post_title)
            ->setSlug($post->post_name)
            ->setDarujmeId($data['darujme_id'] ?? '')
            ->setShortDescription($data['short_description'] ?? '')
            ->setContent($data['content'] ?? '')
            ->setGoalAmount($data['goal_amount'])
            ->setCurrentAmount($data['start_amount'] ?? 0);
    }
}
