<?php

namespace App\Models;

use DateInterVal;
use DateTime;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use function easter_date;

/**
 * App\Models\NationalHolidayYear
 *
 * @property int $id
 * @property int $year
 * @property int $monday
 * @property int $tuesday
 * @property int $wednesday
 * @property int $thursday
 * @property int $friday
 * @property int $saturday
 * @property int $sunday
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read array $work_days
 * @method static Builder|NationalHolidayYear newModelQuery()
 * @method static Builder|NationalHolidayYear newQuery()
 * @method static Builder|NationalHolidayYear query()
 * @method static Builder|NationalHolidayYear whereCreatedAt($value)
 * @method static Builder|NationalHolidayYear whereFriday($value)
 * @method static Builder|NationalHolidayYear whereId($value)
 * @method static Builder|NationalHolidayYear whereMonday($value)
 * @method static Builder|NationalHolidayYear whereSaturday($value)
 * @method static Builder|NationalHolidayYear whereSunday($value)
 * @method static Builder|NationalHolidayYear whereThursday($value)
 * @method static Builder|NationalHolidayYear whereTuesday($value)
 * @method static Builder|NationalHolidayYear whereUpdatedAt($value)
 * @method static Builder|NationalHolidayYear whereWednesday($value)
 * @method static Builder|NationalHolidayYear whereYear($value)
 * @mixin Eloquent
 */
class NationalHolidayYear extends Model
{
    use HasFactory;

    protected $fillable = ['year'];

    protected static function boot()
    {
        self::created(function (NationalHolidayYear $year) {
            $year->calculateHolidays();
        });

        parent::boot();
    }

    /**
     * Return an array of work days.
     *
     * @noinspection PhpUnused
     */
    protected function workDays(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->only(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'])
        );
    }

    /**
     * Function to calculate the amount of national holidays per weekday.
     *
     * For now this function is based on simple code provided by: https://gist.github.com/tvlooy/1894247
     *
     * National holidays can change so this should be replaced by something like:
     * https://www.reinder.eu/nationale-feestdagen-api-heel-europa/
     *
     * But for some reason the promised api key never arrived in my mailbox (Yes I checked spam).
     */
    public function calculateHolidays()
    {
        $dates = collect();

        // Set days
        $dates->add(new DateTime("$this->year-01-01")); // New year
        $dates->add(new DateTime("$this->year-05-05")); // Liberation day
        $dates->add(new DateTime("$this->year-12-25")); // Christmas
        $dates->add(new DateTime("$this->year-12-26")); // Boxing day (Christmas second day)
        $dates->add(new DateTime("$this->year-12-31")); // New years eve

        $monarchDay = new DateTime("$this->year-04-27");

        // If the birthday of our monarch is on a sunday, it's moved to the saturday before.
        if ($monarchDay->format('w') === '0') {
            $monarchDay->sub(new DateInterval('P1D'));
        }

        $dates->add($monarchDay);

        // easter_date is limited to the Unix timestamp range 1970-2037, set a reminder for the future.
        // https://www.php.net/manual/en/function.easter-date.php
        if ($this->year >= 1970 && $this->year <= 2037) {
            // Calculated holidays
            $easter = new DateTime();
            $easter->setTimestamp(easter_date($this->year)); // Use PHP's easter function

            $dates->add($easter);

            $easterMonday = clone $easter;
            $easterMonday->add(new DateInterVal('P1D')); // 1 day after Easter

            $dates->add($easterMonday);

            $goodFriday = clone $easter;
            $goodFriday->sub(new DateInterval('P2D')); // 2 days before Easter

            $dates->add($goodFriday);

            $ascensionDay = clone $easter;
            $ascensionDay->add(new DateInterVal('P39D')); // 39 days after Easter

            $dates->add($ascensionDay);

            $whitSunday = clone $ascensionDay;
            $whitSunday->add(new DateInterVal('P10D')); // 10 days after Ascension day

            $dates->add($whitSunday);

            $whitMonday = clone $whitSunday;
            $whitMonday->add(new DateInterVal('P1D')); // 1 day after whit sunday

            $dates->add($whitMonday);
        }

        $dates->each(function (DateTime $date) {
            // Get the textual weekday of the date and add 1 to that day of the year.
            $weekday = strtolower($date->format('l'));

            $this->$weekday++;
        });

        $this->save();
    }
}
