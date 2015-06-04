<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.05.04.
 * Time: 10:01
 */

namespace app\components;

use DateInterval;

class DateHelper
{

    private static $MONTH_NAMES = ['Január', 'Február', 'Március', 'Április', 'Május', 'Június', 'Július',
        'Augusztus', 'Szeptember', 'Október', 'November', 'December'];

    private static $DAY_NAMES = ['Vasárnap','Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'];

    public static function getMonthName($i)
    {
        return self::$MONTH_NAMES[$i - 1];
    }

    public static function getDayWithDayName($date) {
        $dw = date( "w", strtotime($date));


        return $date.", ".self::$DAY_NAMES[intval($dw)%7];
    }


    public static function getLastMonday($date)
    {
        if (!$date) {
            $date = new \DateTime('now');
        } else {
            $date = new \DateTime($date);
        }
        $day = $date->format('N') - 1;
        $date = $date->sub(new DateInterval("P{$day}D"))->format('Y-m-d');
        return $date;
    }

    public static function getNextSunday($date)
    {
        if (!$date) {
            $date = new \DateTime('now');
        } else {
            $date = new \DateTime($date);
        }
        $day = 7 - $date->format('N');
        $date = $date->add(new DateInterval("P{$day}D"))->format('Y-m-d');
        return $date;
    }

    public function getDayName($date)
    {

    }
}