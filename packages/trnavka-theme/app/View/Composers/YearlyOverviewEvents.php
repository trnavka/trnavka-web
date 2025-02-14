<?php

namespace App\View\Composers;

use App\Services\WordPress;
use DateTimeImmutable;
use Generator;
use Roots\Acorn\View\Composer;
use Symfony\Component\HttpFoundation\Request;

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

    public function __construct(
        private WordPress $wp,
        private Request   $request
    )
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
        $services = $this->services($year);
        $serviceIdIndex = [];

        foreach ($services as $index => $service) {
            if (isset($service['id'])) {
                $serviceIdIndex[$service['id']] = $index;
            }
        }

        $selectedService = $services[$serviceIdIndex[$this->request->query->get('sluzba', '')] ?? null] ?? null;

	    $filteredEvents = [];
        $globalEventCount = 0;

        foreach ($events as $event) {
            $selectedServiceId = $selectedService['id'] ?? null;
            $index = $serviceIdIndex[$event['service_id']] ?? null;

            if (empty($event['service_id'])) {
                $globalEventCount++;
            }

            if (null !== $index) {
                $services[$index]['event_count'] = ($services[$index]['event_count'] ?? 0) + 1;
            }

            if (null === $selectedServiceId || $selectedServiceId === $event['service_id'] || empty($event['service_id'])) {
                $filteredEvents[] = $event;
            }
        }

        foreach ($services as $index => $service) {
            $services[$index]['event_count'] = ($service['event_count'] ?? 0) + $globalEventCount;
        }

	    $now = new DateTimeImmutable();

        return [
            'year' => $year,
            'allServices' => $services,
            'services' => null === $selectedService ? $services : [$selectedService],
            'events' => $filteredEvents,
            'selectedService' => $selectedService,
            'show2PercentMessage' => $now->format('m-d') > '01-14' && $now->format('m-d') < '03-15',
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
                'service_id' => $data[5],
                'service' => $this->serviceName($data[5]),
                'icon' => $this->svgIconName($data[5]),
                'emphasize' => 'áno' === $data[6],
                'comment' => nl2br($data[7]),
                'image' => $data[8],
                'link_label' => $data[9] ?? null,
                'link_url' => $data[10] ?? null,
                'cta' => str_replace('trnavka@trnavka.sk', '<a href="mailto:trnavka@trnavka.sk">trnavka@trnavka.sk</a>', $data[11] ?? ''),
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
            'farnost' => 'church.svg',
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
            'farnost' => 'Farnosť',
            'fg' => 'Poradenské centrum Family Garden',
        ];

        return $serviceNames[$serviceCode] ?? 'Saleziánske dielo na Trnávke';
    }

    private function services(string $year): array
    {
        $services = [
            [
                'title' => 'Oratko',
                'title_main' => 'v Oratku na&nbsp;Trnávke',
                'title_description' => 'v Oratku/Domke na Trnávke',
                'id' => 'oratko',
                'image' => '03-oratko.jpg',
                '2%' => 'https://trnavka.sk/dvepercentadomke/'
            ],
            [
                'title' => 'Farnosť',
                'title_main' => 'vo farnosti na Trnávke',
                'title_description' => 'vo farnosti na Trnávke',
                'id' => 'farnost',
                'image' => '01-farnost.jpg'
            ],
            [
                'title' => 'Futbalový klub',
                'title_main' => 'vo futbalovom klube na&nbsp;Trnávke',
                'title_description' => 'vo futbalovom klube SDM Domino na Trnávke',
                'id' => 'domino',
                'image' => '02-futbalovy-klub.jpg',
                '2%' => 'https://www.sdmdomino.sk/darujte-nam-2/'
            ],
            [
                'title' => 'Materské centrum',
                'title_main' => 'v materskom centre na Trnávke',
                'title_description' => 'v materskom centre Margarétka na Trnávke',
                'id' => 'mc',
                'image' => '05-materske-centrum.jpg',
            ],
            [
                'title' => 'Skauti',
                'title_main' => 'u skautov na Trnávke',
                'title_description' => 'u skautov 34. zboru don Bosca na Trnávke',
                'id' => 'skauti',
                'image' => '07-skauti.jpg',
            ],
            [
                'title' => 'Škôlka',
                'id' => 'skolka',
                'title_main' => 'v saleziánskej škôlke na Trnávke',
                'title_description' => 'v škôlke Mamy Margit na Trnávkey',
                'image' => '06-skolka.jpg',
                '2%' => 'https://msmamymargity.sk/percenta2/'
            ],
            [
                'title' => 'Poradenské centrum',
                'title_main' => 'v poradenskom centre na Trnávke',
                'title_description' => 'v poradenskom centre Family Garden na Trnávke',
                'id' => 'fg',
                'image' => '04-rodinna-poradna.jpg',
                '2%' => 'https://familygarden.sk/vase-2-pre-zdravsie-vztahy-v-rodinach/'
            ],
        ];

        $yearServices = match ($year) {
            '2023' => [
                'oratko' => [
                    [440, 'detí na letných táboroch'],
                    [120, 'animátorov'],
                    [1060, 'stretiek detí a mladých'],
                ],
                'farnost' => [
                    [111, 'prvoprijímajúcich + birmovancov'],
                    [34, 'animátorov pripravujúcich deti a mladých na sviatosti'],
                    [890, 'svätých omší'],
                ],
                'domino' => [
                    [851, 'detí na letných kempoch a sústredeniach'],
                    [550, 'hráčov od 6 do 19 rokov'],
                    [72, 'trénerov a dobrovoľníkov'],
                ],
                'mc' => [
                    [281, 'krúžkových hodín pre najmenších'],
                    [15, 'prednášok pre rodičov'],
                    [12, 'dobrovoľníčiek, ktoré to celé organizovali'],
                ],
                'skauti' => [
                    [110, 'detí a mladých na letnom tábore'],
                    [25, 'animátorov (radcov + vodcov)'],
                    [300, 'stretiek (družinoviek)'],
                ],
                'skolka' => [
                    [60, 'detí v troch triedach'],
                    [13, 'učiteliek a ďalšieho personálu'],
                ],
                'fg' => [
                    [320, 'účastníkov vzdelávaní'],
                    [184, 'stretnutí s pármi či jednotlivcami'],
                    [13, 'kurzov a workshopov'],
                ],
            ],
            '2024' => [
                'oratko' => [
                    [519, 'detí na letných táboroch'],
                    [131, 'animátorov'],
                    [1100, 'stretiek detí a mladých'],
                ],
                'farnost' => [
                    [48, 'pokrstených'],
                    [111, 'prvoprijímajúcich'],
                    [53, 'birmovancov'],
                ],
                'domino' => [
                    [851, 'detí na letných kempoch a sústredeniach'],
                    [610, 'hráčov od 6 do 19 rokov'],
                    [72, 'trénerov a dobrovoľníkov'],
                ],
                'mc' => [
                    [324, 'krúžkových hodín pre najmenších'],
                    [8, 'prednášok pre rodičov'],
                    [12, 'dobrovoľníčiek, ktoré to celé organizovali'],
                ],
                'skauti' => [
                    [110, 'detí a mladých na letnom tábore'],
                    [35, 'aktívnych skautov'],
                    [350, 'stretiek (družinoviek)'],
                ],
                'skolka' => [
                    [64, 'detí v troch triedach'],
                    [14, 'učiteliek a ďalšieho personálu'],
                    [53, 'duchovných, kultúrnych, vzdelávacích a spoločenských aktivít pre deti a ich rodinu'],
                ],
                'fg' => [
                    [605, 'účastníkov vzdelávaní'],
                    [160, 'stretnutí s pármi či jednotlivcami'],
                    [11, 'kurzov a workshopov'],
                ],
            ],
            default => []
        };

        $result = [];

        foreach ($services as $service) {
            $numbers = $yearServices[$service['id']] ?? null;

            if (null !== $numbers) {
                $result[] = $service + [
                    'numbers' => $numbers,
                ];
            }
        }

        return $result;
    }
}
