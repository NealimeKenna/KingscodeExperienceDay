<?php

namespace App\Http\Controllers;

use App\Models\NationalHolidayYear;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function bestDaysToWork(Request $request): array
    {
        $request->validate([
            'hours' => ['required', 'numeric', 'between:0,40'],
            // easter_date is limited to the Unix timestamp range 1970-2037, set a reminder for the future.
            // https://www.php.net/manual/en/function.easter-date.php
            'year' => ['required', 'numeric', 'between:1970,2037']
        ]);

        // Creating a new NationalHolidayYear will automatically calculate the holidays per weekday.
        $year = NationalHolidayYear::firstOrCreate(['year' => $request->input('year')]);

        // Ceil the daysToWork so we also take in account partial workdays.
        $daysToWork = ceil($request->input('hours') / 8);
        $workDays = $year->work_days;

        // Sort the work days by most holidays per work day.
        arsort($workDays);

        // Splice the array based on how many days you need to work.
        return array_keys(array_splice($workDays, 0, $daysToWork));
    }
}
