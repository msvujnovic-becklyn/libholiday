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
namespace Holiday\UnitedKingdom;

use Holiday\Holiday;

class NorthernIreland extends UnitedKingdom
{
    protected function getHolidays($year)
    {
        $timezone = $this->timezone;

        $easter = $this->getEaster($year);
        $data   = parent::getHolidays($year);

        $date = new Holiday("01.01." . $year, "Neujahrstag", $timezone);
        $data[] = $date;
        $date = new Holiday("17.03" . $year, "St. Patrick's Day", $timezone);
        if( parent::checkForWeekend( $date ) ) {
            $date->modify("next monday");
        }
        $data[] = $date;
        $date = new Holiday("12.07" . $year, "Battle of the Boyne", $timezone);
        if( parent::checkForWeekend( $date ) ) {
            $date->modify("next monday");

        }
        $data[] = $date;


        $data[] = new Holiday($easter, "Ostermontag", $timezone);
        $data[0]->modify("+1 day");


        return $data;
    }
}
