<?php
namespace Tests\Unit;

use App\Utils\SeasonUtil;
use Carbon\Carbon;
use Tests\TestCase;

class SeasonUtilTest extends TestCase
{
    public function test_spring_date_return_correct_seasons()
    {
        $seasonDates = SeasonUtil::getCurrentSeasonDates(Carbon::parse('2021-03-01'));
        $this->assertEquals('2021-01-01', $seasonDates['currentSeasonDates']['start']->format('Y-m-d'));
        $this->assertEquals('2021-05-31', $seasonDates['currentSeasonDates']['end']->format('Y-m-d'));
        $this->assertEquals('2020-06-01', $seasonDates['previousSeasonDates']['start']->format('Y-m-d'));
        $this->assertEquals('2020-12-31', $seasonDates['previousSeasonDates']['end']->format('Y-m-d'));
    }

    public function test_fall_date_returns_correct_seasons()
    {
        $seasonDates = SeasonUtil::getCurrentSeasonDates(Carbon::parse('2021-10-01'));
        $this->assertEquals('2021-06-01', $seasonDates['currentSeasonDates']['start']->format('Y-m-d'));
        $this->assertEquals('2021-12-31', $seasonDates['currentSeasonDates']['end']->format('Y-m-d'));
        $this->assertEquals('2021-01-01', $seasonDates['previousSeasonDates']['start']->format('Y-m-d'));
        $this->assertEquals('2021-05-31', $seasonDates['previousSeasonDates']['end']->format('Y-m-d'));
    }
}