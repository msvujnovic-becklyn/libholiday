<?php
/**
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License version 3 as published by the Free Software Foundation
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * @copyright  Copyright (c) 2012 Mayflower GmbH (http://www.mayflower.de)
 * @license    LGPL v3 (See LICENSE file)
 */
namespace Holiday\Test;
use DateTimeZone;
use Holiday;

class UnitedKingdomWalesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DateTimeZone
     */
    private $timezone = null;

    public function setUp()
    {
        $this->timezone = new DateTimeZone('UTC');
    }

    public function testUnitedKingdomWalesCalculations()
    {
        $start = new \DateTime("2012-01-01", $this->timezone);
        $end   = new \DateTime("2012-12-31", $this->timezone);

        $UnitedKingdomWales = new Holiday\Gb\GbWls($this->timezone);

        $this->assertCount(10, $UnitedKingdomWales->between($start, $end));

        $days = $UnitedKingdomWales->between($start, $end);
        $this->assertEquals(
            new Holiday\Holiday("6.4.2012", "Karfreitag", $this->timezone),
            $days[0]);
        $this->assertEquals(
            new Holiday\Holiday("07.5.2012", "Early May Bank Holiday", $this->timezone),
            $days[1]);
    }

    public function testUnitedKingdomWalesBetween()
    {
        $UnitedKingdomWales = new Holiday\Gb\GbWls($this->timezone);
        $res = $UnitedKingdomWales->between(
                new \DateTime("1.4.2012", $this->timezone),
                new \DateTime("30.4.2012", $this->timezone));
        $this->assertCount(3, $res);
        $this->assertContainsOnlyInstancesOf('Holiday\Holiday', $res);

        $mapped = array_values(
            array_map(function(\DateTime $dt) {
                return $dt->format("d.m.Y H:i");
            }, $res));

        $expected = array(
            '06.04.2012 00:00',
            '08.04.2012 00:00',
            '09.04.2012 00:00');

        sort($expected);
        sort($mapped);
        $this->assertEquals($expected, $mapped);

        $this->assertCount(10, $UnitedKingdomWales->between(
            new \DateTime("1.5.2012", $this->timezone),
            new \DateTime("1.5.2013", $this->timezone)));

        $res = $UnitedKingdomWales->between(
                new \DateTime("27.5.2013", $this->timezone),
                new \DateTime("27.5.2013", $this->timezone));

        $this->assertEquals(
            new Holiday\Holiday("27.05.2013", "Spring Bank Holiday", $this->timezone),
            array_pop($res));
    }

    public function testUnitedKingdomWalesPST() {
        $timezone = new \DateTimeZone("PST");
        $UnitedKingdomWales = new Holiday\Gb\GbWls($timezone);
        $res = $UnitedKingdomWales->between(
            new \DateTime("27.5.2013", $timezone),
            new \DateTime("27.5.2013", $timezone));

        $this->assertEquals(
            new Holiday\Holiday("27.05.2013", "Spring Bank Holiday", $timezone),
            array_pop($res));
    }

    public function testWeights() {
        $UnitedKingdomWales       = new Holiday\Gb\GbWls($this->timezone);
        $holidays = $UnitedKingdomWales->between(
            new \DateTime("2012-12-24", $this->timezone),
            new \DateTime("2012-12-24", $this->timezone));
        $holiday  = array_pop($holidays);
        $this->assertEquals(0.5, $holiday->weight, 'Heilig Abend weight', 0.001);
    }

    public function testHolidayDisplacement() {
        $UnitedKingdomWales = new Holiday\Gb\GbWls($this->timezone);
        $this->assertCount(0, $UnitedKingdomWales->between(
            new \DateTime("2015-12-26", $this->timezone),
            new \DateTime("2015-12-26", $this->timezone)));
        $this->assertCount(1, $UnitedKingdomWales->between(
            new \DateTime("2015-12-28", $this->timezone),
            new \DateTime("2015-12-28", $this->timezone)));
    }

    public function testBug() {
        $timezone = new \DateTimeZone('UTC');
        $UnitedKingdomWales      = new Holiday\Gb\GbWls($timezone);
        $fail    = $UnitedKingdomWales->between(
            new \DateTime("2011-06-01", $timezone),
            new \DateTime("2012-05-01", $timezone));
        $correct = $UnitedKingdomWales->between(
            new \DateTime("2011-05-02", $this->timezone),
            new \DateTime("2012-05-01", $this->timezone));
        $this->assertNotEquals(12, count($fail));
        $this->assertNotEquals(12, count($correct));
        $this->assertEquals(8, count($fail));
    }
}
