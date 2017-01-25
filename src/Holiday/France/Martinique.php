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
namespace Holiday\France;

use Holiday\Holiday;

class Martinique extends France
{
    protected function getSpecial($year)
    {
        $timezone = $this->timezone;

        $easter = $this->getEaster($year);
        $data   = parent::getHolidays($year);
        $date = new Holiday($easter, "Karfreitag", $timezone);
        $date->modify("-2 days");
        $data[] = $date;
        $data[] = new Holiday("22.05." . $year, "Abschaffung der Sklaverei", $timezone);

        return $data;
    }
}
