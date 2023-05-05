<?php

namespace App\Entity;

class FinancialSubject
{
    public int $id;
    public string $title;
    public string $slug;
    public string $description = '';
    public int $incomeServiceFees = 0;
    public int $incomeCollections = 0;
    public int $incomeParishCollections = 0;
    public int $incomeGrants = 0;
    public int $income2percents = 0;
    public int $costsUtility = 0;
    public int $costsMaterial = 0;
    public int $costsMaintenance = 0;
    public int $costsHr = 0;
    public int $costsFees = 0;
    public int $costsOther = 0;

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

    public function setIncomeServiceFees(int $incomeServiceFees): self
    {
        $this->incomeServiceFees = $incomeServiceFees;
        return $this;
    }

    public function setIncomeCollections(int $incomeCollections): self
    {
        $this->incomeCollections = $incomeCollections;
        return $this;
    }

    public function setIncomeParishCollections(int $incomeParishCollections): self
    {
        $this->incomeParishCollections = $incomeParishCollections;
        return $this;
    }

    public function setIncomeGrants(int $incomeGrants): self
    {
        $this->incomeGrants = $incomeGrants;
        return $this;
    }

    public function setIncome2percents(int $income2percents): self
    {
        $this->income2percents = $income2percents;
        return $this;
    }

    public function getIncome(): int {
        return $this->incomeServiceFees + $this->incomeCollections + $this->incomeParishCollections + $this->incomeGrants + $this->income2percents;
    }

    public function getCosts(): int {
        return $this->costsUtility + $this->costsMaterial + $this->costsMaintenance + $this->costsHr + $this->costsFees + $this->costsOther;
    }

    public function getLoss(): int {
        return $this->getIncome() - $this->getCosts();
    }

    public function setCostsUtility(int $costsUtility): self
    {
        $this->costsUtility = $costsUtility;
        return $this;
    }

    public function setCostsMaterial(int $costsMaterial): self
    {
        $this->costsMaterial = $costsMaterial;
        return $this;
    }

    public function setCostsMaintenance(int $costsMaintenance): self
    {
        $this->costsMaintenance = $costsMaintenance;
        return $this;
    }

    public function setCostsHr(int $costsHr): self
    {
        $this->costsHr = $costsHr;
        return $this;
    }

    public function setCostsFees(int $costsFees): self
    {
        $this->costsFees = $costsFees;
        return $this;
    }

    public function setCostsOther(int $costsOther): self
    {
        $this->costsOther = $costsOther;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
