<?php

namespace CelciusTech\CoreBundle\Helper;

class Formatter
{
    /**
     * Read more
     * @link http://stackoverflow.com/questions/4258557/limit-text-length-in-php-and-provide-read-more-link
     *
     * @param string text
     * @param integer length
     *
     * @return string truncated text
     */
    static public function more($text, $len)
    {
        $text = strip_tags($text);

        if (strlen($text) > $len) {

            // truncate string
            $stringCut = substr($text, 0, $len);

            // make sure it ends in a word so assassinate doesn't become ass...
            $text = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
        }

        return $text;
    }

    /**
     * @link http://css-tricks.com/snippets/php/time-ago-function/
     * Return time in ago format
     *
     * @param Datetime
     *
     * @return string formated
     */
    static public function ago(\DateTime $date)
    {
        $time = $date->getTimestamp();
        $periods = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
        $lengths = array('60','60','24','7','4.35','12','10');

        $now = time();
        $difference     = $now - $time;
        $tense         = 'ago';

        for($j = 0, $cnt = count($lengths); $difference >= $lengths[$j] && $j < $cnt - 1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= 's';
        }

        return $difference.' '.$periods[$j].' ago';
    }

    /**
     * Format php array to sql array
     *
     * @param array $arr
     * 
     * @return string sql array
     */
    static public function arrayToSql($arr = array())
    {
        $arrString = strtolower(implode("', '", $arr));
        return "('$arrString')";
    }

    /**
     * Return currency formatted number
     *
     * @param float $number
     * @param string $curreny
     * @param boolean $prefix true if prefix, false if suffix
     *
     * @return string formatted number
     */
    static public function money($number, $currency = 'Rp', $prefix = true)
    {
        if ($prefix) {
            return $currency.number_format($number, 2, ',', '.');
        }

        return number_format($number, 2, ',', '.').$currency;
    }
}
