<?php

namespace App\Entity;

class Campaign
{
    public int $id;
    public string $title;
    public string $slug;
    public string $darujmeId;
    public string $darujmeFeedId;
    public string $shortDescription;
    public string $content;
    public null|int $goalAmount = null;
    public int $currentAmount = 0;

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function setDarujmeId(string $darujmeId): self
    {
        $this->darujmeId = $darujmeId;
        return $this;
    }

    public function setDarujmeFeedId(string $darujmeFeedId): self
    {
        $this->darujmeFeedId = $darujmeFeedId;
        return $this;
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function setGoalAmount(int|null $goalAmount): self
    {
        $this->goalAmount = $goalAmount;
        return $this;
    }

    public function setCurrentAmount(int $currentAmount): self
    {
        $this->currentAmount = $currentAmount;
        return $this;
    }
}
