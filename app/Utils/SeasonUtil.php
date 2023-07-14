<?php

namespace App\Utils;

use Carbon\Carbon;

class SeasonUtil
{
    /**
     * Returns the start and end dates of the current and previous seasons
     */
    public static function getCurrentSeasonDates($currentDate)
    {
        $seasons = config('kota.seasons');

        // Determine the current season
        $currentSeason = '';
        foreach ($seasons as $season => $dates) {
            $startDate = Carbon::createFromFormat('d.m.', $dates['start'])->year($currentDate->year);
            $endDate = Carbon::createFromFormat('d.m.', $dates['end'])->year($currentDate->year);

            if ($currentDate->between($startDate, $endDate)) {
                $currentSeason = $season;
                break;
            }
        }

        // Get the start and end dates of the current season
        $currentSeasonStartDate = Carbon::createFromFormat('d.m.', $seasons[$currentSeason]['start'])->year($currentDate->year);
        $currentSeasonEndDate = Carbon::createFromFormat('d.m.', $seasons[$currentSeason]['end'])->year($currentDate->year);

        // Determine the previous season and year
        $previousYear = ($currentSeason === 'kevät') ? ($currentDate->year - 1) : $currentDate->year;
        $previousSeason = ($currentSeason === 'kevät') ? 'syksy' : 'kevät';

        // Get the start and end dates of the previous season
        $previousSeasonStartDate = Carbon::createFromFormat('d.m.', $seasons[$previousSeason]['start'])->year($previousYear);
        $previousSeasonEndDate = Carbon::createFromFormat('d.m.', $seasons[$previousSeason]['end'])->year($previousYear);

        return [
            'currentSeasonDates' => [
                'start' => $currentSeasonStartDate,
                'end' => $currentSeasonEndDate,
                'name' => ucfirst($currentSeason) . ' ' . $currentDate->year
            ],
            'previousSeasonDates' => [
                'start' => $previousSeasonStartDate,
                'end' => $previousSeasonEndDate,
                'name' => ucfirst($previousSeason) . ' ' . $previousYear
            ]
        ];
    }
}
