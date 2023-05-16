<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

}
