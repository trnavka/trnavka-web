<?php

namespace App\View\Composers;

use App\Form\Type\DarujmeDonationType;
use App\Form\Type\DonationType;
use App\Repositories\CampaignRepository;
use App\Services\WordPress;
use Roots\Acorn\View\Composer;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class CampaignPost extends Composer
{
    /**
     * @var array
     */
    protected static $views = [
        'partials.content-single-campaign',
    ];

    public function __construct(
        private CampaignRepository $campaignRepository,
        private FormFactory        $formFactory,
        private Environment        $twig,
        private WordPress          $wp,
        private Request            $request
    )
    {
    }

    public function override(): array
    {
        $post = $this->wp->currentPost();
        $campaign = $this->campaignRepository->find($post);

        $form = $this->formFactory
            ->createNamedBuilder('donation', DonationType::class, [
                'amount' => 10
            ], [
                'action' => $this->wp->postUrl($post),
            ])
            ->getForm();

        $formContent = null;

        if ($this->request->isMethod('POST')) {
            $form->submit($this->request->get('donation'));

            if ($form->isValid()) {
                $data = $form->getData();
                $form = $this->formFactory
                    ->createNamedBuilder('donation', DarujmeDonationType::class, [
                        'campaign_id'       => $campaign->darujmeId,
                        'value'             => $data['amount'] ?? $data['otherAmount'],
                        'payment_method_id' => $data['paymentType'],
                        'first_name'        => $data['firstName'],
                        'last_name'         => $data['lastName'],
                        'email'             => $data['email'],
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
            'campaign' => $campaign,
            'form' => $formContent
        ];
    }
}
