<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class DonationType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array                $options
    ): void
    {
        $isCampaign = $options['donation_type'] === 'campaign';

        $builder
            ->add('amount', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'choices' => $isCampaign ? [
                    '10&nbsp;€' => 10,
                    '30&nbsp;€' => 30,
                    '99&nbsp;€' => 99,
                    'Iná suma' => null,
                ] : [
                    '9&nbsp;€' => 9,
                    '29&nbsp;€' => 29,
                    '99&nbsp;€' => 99,
                    'Iná suma' => '',
                ],
                'choice_attr' => function (
                    $choice,
                    $key
                ) {
                    return 'Iná suma' === $key ? ['data-is-other' => 'T'] : [];
                },
            ])
            ->add('otherAmount', NumberType::class, [
                'label' => 'Iná suma',
                'html5' => true,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Iná suma'
                ],
                'constraints' => [
                    new NotBlank([
                        'groups' => ['other_amount'],
                        'message' => 'Vyberte z predvolených súm alebo zadajte vlastnú sumu',
                    ])
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Meno',
                'attr' => [
                    'placeholder' => 'Meno'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Zadajte meno'])
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Priezvisko',
                'attr' => [
                    'placeholder' => 'Priezvisko'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Zadajte priezvisko'])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Emailová adresa',
                'attr' => [
                    'placeholder' => 'Emailová adresa'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Zadajte emailovú adresu']),
                    new Email(['message' => 'Zadajte platnú emailovú adresu'])
                ]
            ])
            ->add('paymentType', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'choices' => $isCampaign ? [
                    'Platba kartou' => '1342d2af-a343-4e73-9f5a-7593b9978697',
                    'Platba prevodom na účet' => '3dcf55d1-6383-45b4-b098-dc588187b854',
                    'Platba cez internet banking (VÚB)' => 'f2e7956e-a3f6-4bff-9e18-2ab3096a5bed',
                    'Platba cez internet banking (Slovenská Sporiteľňa)' => 'c07e714c-74ed-4ac6-ab63-3898a73f1fa0',
                    'Platba cez internet banking (Tatra banka)' => '38409407-c4ec-4060-b4a1-4792f29335ad',
                ] : [
                    'Platba kartou' => 'b71ff7cf-39f7-40db-8a34-e1f30292c215',
                    'Platba trvalým príkazom' => 'f425f4af-74ce-4a9b-82d6-783c93b80f17',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Vyberte spôsob platby'])
                ]
            ])
            ->add('terms', CheckboxType::class, [
                'label' => 'Potvrdzujem, že mám preštudované informácie o <a href="http://saleziani.sk/msaleziani/gdpr" target="_blank">spracovaní osobných údajov</a> organizáciou Saleziáni dona Bosca – Slovenská provincia, ktorej poskytujem dar',
                'label_html' => true,
                'constraints' => [
                    new IsTrue()
                ]
            ])
            ->add('gdpr', CheckboxType::class, [
                'label' => 'Potvrdzujem, že mám preštudované informácie o spracovaní Osobných údajov v systéme <a href="https://darujme.sk/pravidla-ochrany-osobnych-udajov/" target="_blank">DARUJME.sk</a>',
                'label_html' => true,
                'constraints' => [
                    new IsTrue()
                ]
            ]);

        if ($isCampaign) {
            $builder
                ->add('isCampaignForm', HiddenType::class, [
                    'mapped' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'validation_groups' => function (FormInterface $form) {
                if (null === $form->getData()['amount']) {
                    return ['Default', 'other_amount'];
                }

                return ['Default'];
            },
            'donation_type' => 'campaign'
        ]);
    }
}
