<?php

namespace Tests\Unit;

use App\Models\NationalHolidayYear;
use Tests\TestCase;

class NationalHolidayYearTest extends TestCase
{
    /**
     * Make sure the work_days property is an array.
     */
    public function testWorkDays(): void
    {
        /** @var NationalHolidayYear $year */
        $year = NationalHolidayYear::factory()->create();

        $this->assertIsArray($year->work_days);
    }
}
