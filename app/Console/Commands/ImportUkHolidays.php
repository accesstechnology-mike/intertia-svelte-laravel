<?php

namespace App\Console\Commands;

use App\Models\Holiday;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use DateTime;

class ImportUkHolidays extends Command
{
    protected $signature = 'import:uk-holidays';

    protected $description = 'Imports UK public holidays and Christmas week days off';

    public function handle()
    {
        $response = Http::get('https://www.gov.uk/bank-holidays.json');
        $data = $response->json();

        // Choose the region you want to import the holidays from, e.g., 'england-and-wales'
        $holidays = $data['england-and-wales']['events'];

        // Calculate additional days off during the Christmas week
        $christmasDaysOff = $this->getChristmasDaysOff($holidays);

        // Merge bank holidays with Christmas days off
        $holidays = array_merge($holidays, $christmasDaysOff);

        // Save holidays to the database
        foreach ($holidays as $holiday) {
            Holiday::updateOrCreate(
                ['date' => $holiday['date']],
                ['name' => $holiday['title']]
            );
        }

        $this->info('UK public holidays and Christmas week days off imported successfully');
    }


    private function getChristmasDaysOff($holidays)
    {

        $daysOff = [];

        // Find Christmas Day and New Year's Day
        $christmasDay = null;
        $newYearsDay = null;

        $currentYear = (int)(new DateTime())->format('Y');

        foreach ($holidays as $holiday) {
            $holidayDate = new DateTime($holiday['date']);
            $holidayYear = (int)$holidayDate->format('Y');

            if ($holiday['title'] === 'Christmas Day' && $holidayYear === $currentYear) {
                $christmasDay = $holiday['date'];
            } elseif (strpos($holiday['title'], "New Year’s Day") !== false && $holidayYear === $currentYear + 1) {
                $newYearsDay = $holiday['date'];
            }
        }

        if ($christmasDay && $newYearsDay) {
            $christmasDate = new DateTime($christmasDay);
            $newYearsDate = new DateTime($newYearsDay);

            // Create a lookup array for existing holidays
            $existingHolidaysLookup = array_flip(array_column($holidays, 'date'));

            // Add days off during the week between Christmas Day and New Year's Day
            $currentDate = clone $christmasDate;
            while ($currentDate < $newYearsDate) {
                $currentDateString = $currentDate->format('Y-m-d');

                // Check if the date is a weekday (Monday to Friday) and not already a public holiday
                if ($currentDate->format('N') <= 5 && !isset($existingHolidaysLookup[$currentDateString])) {
                    $daysOff[] = [
                        'date' => $currentDateString,
                        'title' => 'Christmas Week Day Off'
                    ];
                }
                $currentDate->modify('+1 day');
            }
        }

        return $daysOff;
    }

    function getCurrentYearHolidays(): array
    {
        $currentYear = (int)(new DateTime())->format('Y');
        $today = new DateTime();

        $christmasDay = new DateTime("{$currentYear}-12-25");
        $newYearsDay = new DateTime("{$currentYear}-01-01");

        // Check if today's date is after Christmas Day
        if ($today > $christmasDay) {
            // Increment the year for the New Year's Day holiday
            $newYearsDay->modify('+1 year');
        } elseif ($today > $newYearsDay) {
            // Increment the year for the Christmas Day holiday
            $christmasDay->modify('+1 year');
        }

        return [
            'christmasDay' => $christmasDay->format('Y-m-d'),
            'newYearsDay' => $newYearsDay->format('Y-m-d'),
        ];
    }
}
