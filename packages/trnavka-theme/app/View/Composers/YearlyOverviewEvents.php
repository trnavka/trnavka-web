<?php

namespace App\View\Composers;

use App\Services\WordPress;
use Generator;
use Roots\Acorn\View\Composer;

class YearlyOverviewEvents extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'yearly-overview',
    ];

    public function __construct(private WordPress $wp)
    {
    }

    public function with(): array
    {
        $events = iterator_to_array($this->loadCsv());

        usort($events, function (
            $a,
            $b
        ) {
            return $a['from_date'] <=> $b['from_date'];
        });

        $year = $this->wp->currentPost()->post_title;

        return [
            'year' => $year,
            'services' => $this->services($year),
            'events' => $events,
        ];
    }

    private function loadCsv(): Generator
    {
        $year = $this->wp->currentPost()->post_title;

        $handle = fopen(resource_path('data/rok-' . $year . '-akcie.csv'), 'r');
        $first = true;

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            if ($first) {
                $first = false;
                continue;
            }

            yield [
                'from_date' => $data[0],
                'month' => ucfirst($this->monthName(substr($data[0], 0, 2))),
                'date' => $this->formatDate($data[0], $data[1], $data[2]),
                'subject' => $data[3],
                'action' => ($data[4][0] ?? '') === ',' ? $data[4] : (' ' . $data[4]),
                'service' => $this->serviceName($data[5]),
                'icon' => $this->svgIconName($data[5]),
                'emphasize' => 'áno' === $data[6],
                'comment' => nl2br($data[7]),
                'image' => $data[8],
                'link_label' => $data[9] ?? null,
                'link_url' => $data[10] ?? null,
            ];
        }
    }

    private function svgIconName(string $service): string
    {
        $iconNames = [
            'domino' => 'soccer.svg',
            'oratko' => 'oratko.svg',
            'mc' => 'materske-centrum.svg',
            'skauti' => 'skauti.svg',
            'farnosť' => 'church.svg',
            'fg' => 'family-garden.svg',
        ];

        return $iconNames[$service] ?? 'trnavka-logo.svg';
    }

    private function formatDate(
        string $dateFrom,
        string $dateTo,
        string $dateRelation
    ): string
    {
        $dateFromParts = explode('-', $dateFrom);
        $dateToParts = explode('-', $dateTo);

        $dateFromDay = ltrim($dateFromParts[1], '0');
        $dateFromMonth = $this->monthName($dateFromParts[0]);

        if (empty($dateTo)) {
            return $dateFromDay . '.&nbsp;' . $dateFromMonth;
        }

        $dateToDay = ltrim($dateToParts[1], '0');
        $dateToMonth = $this->monthName($dateToParts[0]);

        if ('a' === $dateRelation) {
            $pattern = '$from a $to';
        } else {
            $pattern = '$from - $to';
        }

        if ($dateFromMonth === $dateToMonth) {
            $from = $dateFromDay . '.';
            $to = $dateToDay . '.&nbsp;' . $dateToMonth;
        } else {
            $from = $dateFromDay . '.&nbsp;' . $dateFromMonth;
            $to = $dateToDay . '.&nbsp;' . $dateToMonth;
        }

        return str_replace('$from', $from, str_replace('$to', $to, $pattern));
    }

    private function monthName(string $month): string
    {
        $monthNames = [
            '01' => 'január',
            '02' => 'február',
            '03' => 'marec',
            '04' => 'apríl',
            '05' => 'máj',
            '06' => 'jún',
            '07' => 'júl',
            '08' => 'august',
            '09' => 'september',
            '10' => 'október',
            '11' => 'november',
            '12' => 'december',
        ];

        return $monthNames[$month];
    }

    private function serviceName(string $serviceCode)
    {
        $serviceNames = [
            'domino' => 'Futbalový klub SDM Domino',
            'oratko' => 'Oratko',
            'mc' => 'Materské centrum',
            'skauti' => 'Skauti',
            'farnosť' => 'Farnosť',
            'fg' => 'Poradenské centrum Family Garden',
        ];

        return $serviceNames[$serviceCode] ?? 'Saleziánske dielo na Trnávke';
    }

    private function services(string $year): array
    {
        return match ($year) {
            '2023' => [
                [
                    'title' => 'Farnosť',
                    'image' => '01-farnost.jpg',
                    'numbers' => [
                        [111, 'prvoprijímajúcich + birmovancov'],
                        [34, 'animátorov pripravujúcich deti a mladých na sviatosti'],
                        [890, 'svätých omší'],
                    ]
                ],
                [
                    'title' => 'Futbalový klub',
                    'image' => '02-futbalovy-klub.jpg',
                    'numbers' => [
                        [851, 'detí na letných kempoch a sústredeniach'],
                        [550, 'hráčov od 6 do 19 rokov'],
                        [72, 'trénerov a dobrovoľníkov'],
                    ]
                ],
                [
                    'title' => 'Oratko',
                    'image' => '03-oratko.jpg',
                    'numbers' => [
                        [440, 'detí na letných táboroch'],
                        [120, 'animátorov'],
                        [1060, 'stretiek detí a mladých'],
                    ]
                ],
                [
                    'title' => 'Poradenské centrum',
                    'image' => '04-rodinna-poradna.jpg',
                    'numbers' => [
                        [320, 'účastníkov vzdelávaní'],
                        [184, 'stretnutí s pármi či jednotlivcami'],
                        [13, 'kurzov a workshopov'],
                    ]
                ],
                [
                    'title' => 'Materské centrum',
                    'image' => '05-materske-centrum.jpg',
                    'numbers' => [
                        [281, 'krúžkových hodín pre najmenších'],
                        [15, 'prednášok pre rodičov'],
                        [12, 'dobrovoľníčiek, ktoré to celé organizovali'],
                    ]
                ],
                [
                    'title' => 'Škôlka',
                    'image' => '06-skolka.jpg',
                    'numbers' => [
                        [60, 'detí v troch triedach'],
                        [13, 'učiteliek a ďalšieho personálu'],
                    ]
                ],
                [
                    'title' => 'Skauti',
                    'image' => '07-skauti.jpg',
                    'numbers' => [
                        [110, 'detí a mladých na letnom tábore'],
                        [25, 'animátorov (radcov + vodcov)'],
                        [300, 'stretiek (družinoviek)'],
                    ]
                ],
                [
                    'title' => 'Futbalové ihrisko a bežecká dráha',
                    'image' => '08-ihrisko-a-draha.jpg',
                    'numbers' => [
                        ['500+', 'detí a dospelých využili ihrisko a dráhu v čase, keď tam netrénoval futbalový klub'],
                    ]
                ],
                [
                    'title' => 'Zdravotné stredisko',
                    'image' => '09-zdravotne-stredisko.jpg',
                    'numbers' => [
                        [17, 'lekárov'],
                        [8, 'ambulancíí'],
                    ]
                ]
            ],
            '2024' => [
                [
                    'title' => 'Oratko',
                    'image' => '03-oratko.jpg',
                    'numbers' => [
                        [519, 'detí na letných táboroch'],
                        [131, 'animátorov'],
                        [1100, 'stretiek detí a mladých'],
                    ]
                ],
                [
                    'title' => 'Farnosť',
                    'image' => '01-farnost.jpg',
                    'numbers' => [
                        [48, 'pokrstených'],
                        [111, 'prvoprijímajúcich'],
                        [53, 'birmovancov'],
                    ]
                ],
                [
                    'title' => 'Futbalový klub',
                    'image' => '02-futbalovy-klub.jpg',
                    'numbers' => [
                        [851, 'detí na letných kempoch a sústredeniach'],
                        [610, 'hráčov od 6 do 19 rokov'],
                        [72, 'trénerov a dobrovoľníkov'],
                    ]
                ],
                [
                    'title' => 'Materské centrum',
                    'image' => '05-materske-centrum.jpg',
                    'numbers' => [
                        [324, 'krúžkových hodín pre najmenších'],
                        [8, 'prednášok pre rodičov'],
                        [12, 'dobrovoľníčiek, ktoré to celé organizovali'],
                    ]
                ],
                [
                    'title' => 'Skauti',
                    'image' => '07-skauti.jpg',
                    'numbers' => [
                        [110, 'detí a mladých na letnom tábore'],
                        [25, 'animátorov (radcov + vodcov)'],
                        [300, 'stretiek (družinoviek)'],
                    ]
                ],
                [
                    'title' => 'Škôlka',
                    'image' => '06-skolka.jpg',
                    'numbers' => [
                        [64, 'detí v troch triedach'],
                        [14, 'učiteliek a ďalšieho personálu'],
                        [53, 'duchovných, kultúrnych, vzdelávacích a spoločenských aktivít pre deti a ich rodinu'],
                    ]
                ],
                [
                    'title' => 'Poradenské centrum',
                    'image' => '04-rodinna-poradna.jpg',
                    'numbers' => [
                        [605, 'účastníkov vzdelávaní'],
                        [160, 'stretnutí s pármi či jednotlivcami'],
                        [11, 'kurzov a workshopov'],
                    ]
                ],
//                [
//                    'title' => 'Futbalové ihrisko a bežecká dráha',
//                    'image' => '08-ihrisko-a-draha.jpg',
//                    'numbers' => [
//                        ['500+', 'detí a dospelých využili ihrisko a dráhu v čase, keď tam netrénoval futbalový klub'],
//                    ]
//                ],
//                [
//                    'title' => 'Zdravotné stredisko',
//                    'image' => '09-zdravotne-stredisko.jpg',
//                    'numbers' => [
//                        [17, 'lekárov'],
//                        [8, 'ambulancíí'],
//                    ]
//                ]
            ],
            default => []
        };
    }
}
