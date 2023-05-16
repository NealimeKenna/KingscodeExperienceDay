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
        $year = NationalHolidayYear::factory()->make();

        $this->assertIsArray($year->work_days);
        $this->assertContainsOnly('int', $year->work_days);
        $this->assertArrayHasKey('monday', $year->work_days);
        $this->assertArrayHasKey('tuesday', $year->work_days);
        $this->assertArrayHasKey('wednesday', $year->work_days);
        $this->assertArrayHasKey('thursday', $year->work_days);
        $this->assertArrayHasKey('friday', $year->work_days);
        $this->assertArrayNotHasKey('saturday', $year->work_days);
        $this->assertArrayNotHasKey('sunday', $year->work_days);
    }
}
