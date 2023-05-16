<?php

namespace App\Http\Controllers;

use App\Http\Resources\NationalHolidayYearResource;
use App\Models\NationalHolidayYear;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function bestDaysToWork(Request $request): NationalHolidayYearResource
    {
        $request->validate(['hours' => ['required', 'numeric'], 'year' => ['required', 'numeric']]);

        // Creating a new NationalHolidayYear will automatically calculate the holidays per weekday.
        $year = NationalHolidayYear::firstOrCreate(['year' => $request->input('year')]);

        return new NationalHolidayYearResource($year);
    }
}
