<?php

namespace App\View\Composers;

use App\Entity\FinancialSubject;
use App\Form\Type\DarujmeDonationType;
use App\Form\Type\DonationType;
use App\Repositories\CampaignRepository;
use App\Repositories\FinancialSubjectRepository;
use App\Services\Darujme;
use App\Services\WordPress;
use Roots\Acorn\View\Composer;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

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
        private CampaignRepository $campaignRepository,
        private FinancialSubjectRepository $financialSubjectRepository,
        private WordPress          $wp,
        private FormFactory        $formFactory,
        private Environment        $twig,
        private Request            $request,
        private Darujme            $darujme
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

        $form = $this->formFactory
            ->createNamedBuilder('donation', DonationType::class, [
                'amount' => 29
            ], [
                'donation_type' => 'subscription',
                'action' => $this->wp->pageUrl(),
            ])
            ->getForm();

        $formContent = null;

        if ($this->request->isMethod('POST')) {
            $form->submit($this->request->get('donation'));

            if ($form->isValid()) {
                $data = $form->getData();
                $form = $this->formFactory
                    ->createNamedBuilder('donation', DarujmeDonationType::class, [
                        'campaign_id' => 'de161f1d-6f09-4d51-b1ae-d0f2207b9215',
                        'value' => empty($data['amount']) ? $data['otherAmount'] : $data['amount'],
                        'payment_method_id' => $data['paymentType'],
                        'first_name' => $data['firstName'],
                        'last_name' => $data['lastName'],
                        'email' => $data['email'],
                    ], [
                        'action' => 'https://api.darujme.sk/v1/donations/post/'
                    ])
                    ->getForm();

                $formContent = preg_replace('/donation\\[([a-zA-Z_]*)]/ms', '$1', $this->twig->render('darujmeForm.html.twig', array(
                    'form' => $form->createView(),
                )));
            }
        }

        if (null === $formContent) {
            $formContent = $this->twig->render('campaign.html.twig', array(
                'donation_form' => $form->createView(),
            ));
        }

        $financialSubjects = $this->financialSubjectRepository->findAll();
        $trnavkaFinancialSubject = $this->trnavkaMetaFinancialSubject($financialSubjects);
        $subscriptionStats = $this->darujme->subscriptionStats();

        $showDajnatoStats = 'Uhb76xhTV7YeeWPGfu' === $this->request->query->get('dajnato', 'F');

        return [
            'title' => $this->wp->title(),
            'subscription_stats' => $subscriptionStats,
            'subscription_amount' => 31000 + $subscriptionStats->sum / 100,
            'campaigns' => $this->campaignRepository->findAll(),
            'trnavka_financial_subject' => $trnavkaFinancialSubject,
            'financial_subjects' => [$trnavkaFinancialSubject, ...$financialSubjects],
            'form' => $formContent
        ] + ($showDajnatoStats ? [
            'dajnato_stats' => $this->darujme->stats(),
        ] : []);
    }

    /**
     * @param FinancialSubject[] $financialSubjects
     * @return FinancialSubject
     */
    private function trnavkaMetaFinancialSubject(array $financialSubjects): FinancialSubject {
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
