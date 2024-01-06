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

class YearEvents extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '2023',
    ];

    public function with(): array
    {
        return [
            'events' => $this->loadCsv(),
        ];
    }

    private function loadCsv(): Generator
    {
        $handle = fopen(resource_path('data/rok-2023-akcie.csv'), 'r');
        $first = true;

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            if ($first) {
                $first = false;
                continue;
            }

            yield [
                'date' => $this->formatDate($data[0], $data[1], $data[2]),
                'subject' => $data[3],
                'action' => ($data[4][0] ?? '') === ',' ? $data[4] : (' ' . $data[4]),
                'icon' => $this->svgIconName($data[5]),
                'emphasize' => 'áno' === $data[6],
                'comment' => nl2br($data[7]),
                'image' => $data[8],
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
            $pattern = 'od&nbsp;$from do&nbsp;$to';
        }

        if ($dateFromMonth === $dateToMonth) {
            $from = $dateFromDay . '.';
            $to = $dateToDay . '.&nbsp;' . $dateFromMonth;
        }
        else {
            $from = $dateFromDay . '.&nbsp;' . $dateFromMonth;
            $to = $dateToDay . '.&nbsp;' . $dateFromMonth;
        }

        return str_replace('$from', $from, str_replace('$to', $to, $pattern));
    }

    private function monthName(string $month): string
    {
        $monthNames = [
            '01' => 'januára',
            '02' => 'februára',
            '03' => 'marca',
            '04' => 'apríla',
            '05' => 'mája',
            '06' => 'júna',
            '07' => 'júla',
            '08' => 'augusta',
            '09' => 'septembra',
            '10' => 'októbra',
            '11' => 'novembra',
            '12' => 'decembra',
        ];

        return $monthNames[$month];
    }
}
