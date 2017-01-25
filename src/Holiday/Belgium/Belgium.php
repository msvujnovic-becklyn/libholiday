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
namespace Holiday\Belgium;

use Holiday\Calculator;
use Holiday\Holiday;

class Belgium extends Calculator
{
    /**
     * Get public holidays valid in states of Belgium as well as special holidays not valid in states of Belgium.
     * @param int $year
     * @return array
     */
    protected function getHolidays($year)
    {
        return array_merge(
            $this->getPublicHolidays($year),
            $this->getSpecial($year)
        );
    }

    /**
     * Get _public holidays_ only. Not in all states of Belgium days from getSpecial() are public holidays.
     *
     * Moved to dedicated method in order to retain compatibility of getHolidays() with existing code.
     *
     * @param int $year Year
     * @return Holiday[]
     */
    protected function getPublicHolidays($year)
    {
        $timezone = $this->timezone;

        /** @var Holiday[] $data */
        $data = array();
        $easter = $this->getEaster($year);

        $data[] = new Holiday($easter, "Ostermontag", $timezone);
        $data[0]->modify("+1 day");
        $data[] = new Holiday($easter, "Christi Himmelfahrt", $timezone);
        $data[1]->modify("+39 days");
        $data[] = new Holiday($easter, "Pfingstmontag", $timezone);
        $data[2]->modify("+50 days");

        $data[] = new Holiday("01.01." . $year, "Neujahrstag", $timezone);
        $data[] = new Holiday("01.05." . $year, "Tag der Arbeit", $timezone);
        $data[] = new Holiday("21.07." . $year, "Tag der Unabhängigkeit", $timezone);
        $data[] = new Holiday("15.08." . $year, "Mariä Himmelfahrt", $timezone);
        $data[] = new Holiday("01.11." . $year, "Allerheiligen", $timezone);
        $data[] = new Holiday("11.11." . $year, "Tag des Waffenstillstands", $timezone);
        $data[] = new Holiday("25.12." . $year, "Weihnachten", $timezone);

        return $data;
    }

    protected function getSpecial($year)
    {
        $timezone = $this->timezone;

        /** @var Holiday[] $data */
        $data   = array();
        $easter = $this->getEaster($year);

        $data[] = new Holiday($easter, "Pfingstsonntag", $timezone, Holiday::NOTABLE);
        $data[0]->modify("+49 days");
        $data[] = new Holiday($easter, "Ostersonntag", $timezone, Holiday::NOTABLE);

        $data[] = new Holiday("24.12." . $year, "Heilig Abend", $timezone, Holiday::NOTABLE, 0.5);
        $data[] = new Holiday("31.12." . $year, "Silvester", $timezone, Holiday::NOTABLE, 0.5);

        return $data;
    }
}
