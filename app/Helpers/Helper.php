<?php

namespace App\Helpers;


class Helper{
/*
 * Convert seconds to human readable text.
 * Found at: http://csl.sublevel3.org/php-secs-to-human-text/
 *
 */
public static function secs_to_h($secs)
{
        $units = array(
                "Semana"   => 7*24*3600,
                "Día"    =>   24*3600,
                "Hora"   =>      3600,
                "Minuto" =>        60,
                "Segundo" =>         1,
        );
	// specifically handle zero
        if ( $secs == 0 ) return "0";
        $s = "";
        foreach ( $units as $name => $divisor ) {
                if ( $quot = intval($secs / $divisor) ) {
                        $s .= "$quot $name";
                        $s .= (abs($quot) > 1 ? "s" : "") . ", ";
                        $secs -= $quot * $divisor;
                }
        }
        return substr($s, 0, -2);
}

}