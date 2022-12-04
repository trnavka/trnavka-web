<?php

namespace App\View\Composers;

use App\Form\Type\DarujmeDonationType;
use App\Form\Type\DonationType;
use App\Repositories\CampaignRepository;
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
    ];

    public function __construct(
        private CampaignRepository $campaignRepository,
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

        return [
            'title' => $this->wp->title(),
            'campaigns' => $this->campaignRepository->findAll(),
            'form' => $formContent
        ];
    }
}
