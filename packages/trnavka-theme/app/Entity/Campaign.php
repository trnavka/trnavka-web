<?php

namespace App\Entity;

class Campaign
{
    public string $title;
    public string $slug;
    public string $darujmeId;
    public string $shortDescription;
    public string $content;
    public null|int $goalAmount = null;
    public int $currentAmount = 0;

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
