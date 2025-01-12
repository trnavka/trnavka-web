<?php

namespace App\View\Composers;

use App\Entity\FinancialSubject;
use App\Repositories\CampaignRepository;
use App\Repositories\FinancialSubjectRepository;
use App\Services\Dajnato;
use App\Services\Darujme;
use App\Services\WordPress;
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

    public function __construct(private WordPress $wp)
    {
    }

    public function with(): array
    {
        $events = iterator_to_array($this->loadCsv());

        usort($events, function ($a, $b) {
            return $a['from_date'] <=> $b['from_date'];
        });

        return [
            'year' => $this->wp->currentPost()->post_title,
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
        }
        else {
            $pattern = '$from - $to';
        }

        if ($dateFromMonth === $dateToMonth) {
            $from = $dateFromDay . '.';
            $to = $dateToDay . '.&nbsp;' . $dateToMonth;
        }
        else {
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
}
