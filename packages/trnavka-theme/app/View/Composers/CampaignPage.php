<?php

namespace App\View\Composers;

use App\Entity\FinancialSubject;
use App\Repositories\CampaignRepository;
use App\Repositories\FinancialSubjectRepository;
use App\Services\Dajnato;
use App\Services\Darujme;
use App\Services\WordPress;
use Roots\Acorn\View\Composer;
use Symfony\Component\HttpFoundation\Request;

class CampaignPage extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'campaign',
        'finances',
    ];

    public function __construct(
        private CampaignRepository         $campaignRepository,
        private FinancialSubjectRepository $financialSubjectRepository,
        private WordPress                  $wp,
        private Request                    $request,
        private Darujme                    $darujme,
        private Dajnato                    $dajnato
    )
    {
    }

    public function with(): array
    {
        if ('T' === $this->request->query->get('update-campaigns', 'F')) {
            $this->darujme->updateCampaigns();
            exit;
        }

        if ('T' === $this->request->query->get('update-payments', 'F')) {
            $this->darujme->updatePayments();
            exit;
        }

        $financialSubjects = $this->financialSubjectRepository->findAll();
        $trnavkaFinancialSubject = $this->trnavkaMetaFinancialSubject($financialSubjects);
        $subscriptionStats = $this->darujme->subscriptionStats();

        $showDajnatoStats = 'Uhb76xhTV7YeeWPGfu' === $this->request->query->get('dajnato', 'F');

        return [
                'campaign' => $this->dajnato->campaign(),
                'dajnato_cta_form_url' => $this->dajnato->formUrl(null, true),
                'title' => $this->wp->title(),
                'subscription_stats' => $subscriptionStats,
                'subscription_amount' => 31000 + $subscriptionStats->sum / 100,
                'active_campaigns' => $this->campaignRepository->findAllActive(),
                'archived_campaigns' => $this->campaignRepository->findAllArchived(),
                'trnavka_financial_subject' => $trnavkaFinancialSubject,
                'financial_subjects' => [$trnavkaFinancialSubject, ...$financialSubjects],
            ] + ($showDajnatoStats ? [
                'dajnato_stats' => $this->darujme->stats(),
            ] : []);
    }

    /**
     * @param FinancialSubject[] $financialSubjects
     * @return FinancialSubject
     */
    private function trnavkaMetaFinancialSubject(array $financialSubjects): FinancialSubject
    {
        $trnavka = new FinancialSubject();

        $trnavka
            ->setTitle('Celé Saleziánske dielo')
            ->setSlug('trnavka')
            ->setId(0)
            ->setIncomeServiceFees(0)
            ->setIncomeCollections(0)
            ->setIncomeParishCollections(0)
            ->setIncomeGrants(0)
            ->setIncome2percents(0)
            ->setCostsUtility(0)
            ->setCostsMaterial(0)
            ->setCostsMaintenance(0)
            ->setCostsHr(0)
            ->setCostsFees(0)
            ->setCostsOther(0);

        foreach ($financialSubjects as $financialSubject) {
            $trnavka->setIncomeServiceFees($trnavka->incomeServiceFees + $financialSubject->incomeServiceFees);
            $trnavka->setIncomeCollections($trnavka->incomeCollections + $financialSubject->incomeCollections);
            $trnavka->setIncomeParishCollections($trnavka->incomeParishCollections + $financialSubject->incomeParishCollections);
            $trnavka->setIncomeGrants($trnavka->incomeGrants + $financialSubject->incomeGrants);
            $trnavka->setIncome2percents($trnavka->income2percents + $financialSubject->income2percents);
            $trnavka->setCostsUtility($trnavka->costsUtility + $financialSubject->costsUtility);
            $trnavka->setCostsMaterial($trnavka->costsMaterial + $financialSubject->costsMaterial);
            $trnavka->setCostsMaintenance($trnavka->costsMaintenance + $financialSubject->costsMaintenance);
            $trnavka->setCostsHr($trnavka->costsHr + $financialSubject->costsHr);
            $trnavka->setCostsFees($trnavka->costsFees + $financialSubject->costsFees);
            $trnavka->setCostsOther($trnavka->costsOther + $financialSubject->costsOther);
        }

        return $trnavka;
    }
}
