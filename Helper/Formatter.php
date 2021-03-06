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
     * @param string $locale
     *
     * @return string formatted number
     */
    static public function money($number, $currency = 'Rp', $prefix = true, $locale = 'id')
    {
        $sign = '';
        if ($number < 0) {
            $number = abs($number);
            $sign = '- ';
        }
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
        if ($prefix) {
            return $sign.$currency.$numberFormatter->format($number);
        }

        return $sign.$numberFormatter->format($number).$currency;
    }

    /**
     * Format percent
     *
     * @param string
     * @return string
     */
    static public function percent($percent, $symbol = '%')
    {
        if ($percent <= 0) {
            $value = 0;    
        } else {
            $value = trim(rtrim($percent, '0'), '.');
        }

        if ($symbol) {
            $value = $value.$symbol;
        }

        return $value;
    }

    /**
     * Remove non digit characters
     *
     * @param string $str
     * @return string 
     */
    static public function removeNonDigit($str)
    {
    	$str = (string) $str;
        if (count($str) <= 0) return $str;

        $negative = false;
        if ($str[0] == '-') {
            $negative = true;
        }
        if (strpos($str, ',') !== false) {
            // remove trailing zeros
            $str = rtrim($str, '0'); 
            if ($str[count($str) - 1] == ',') {
                // remove comma if last character
                $str = rtrim($str, ',');
            }
        }

        // remove non digit and non comma
        $str = preg_replace('/[^0-9\,]/', '', $str);
        // replace comma with dot
        $str = str_replace(',', '.', $str);

        if ($negative) {
            $str = '-'.$str;
        }

        return $str;
    }

    /**
     * Mengubah angka menjadi terbilang
     *
     * @param int $angka
     * @return string
     */
    static public function terbilang ($angka) {
	   $abil = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
	   if ($angka < 12)
	     return ' ' . $abil[$angka] ;
	   elseif ($angka < 20)
	     return self::terbilang($angka - 10) . ' belas';
	   elseif ($angka < 100)
	     return self::terbilang($angka / 10) . ' puluh' . self::terbilang(fmod($angka,10));
	   elseif ($angka < 200)
	     return ' seratus' . self::terbilang($angka - 100);
	   elseif ($angka < 1000)
	     return self::terbilang($angka / 100) . ' ratus' . self::terbilang(fmod($angka,100));
	   elseif ($angka < 2000)
	     return ' seribu' . self::terbilang($angka - 1000);
	   elseif ($angka < 1000000)
	     return self::terbilang($angka / 1000) . ' ribu' . self::terbilang(fmod($angka,1000));
	   elseif ($angka < 1000000000)
	     return self::terbilang($angka / 1000000) . ' juta' . self::terbilang(fmod($angka,1000000));
	   elseif ($angka < 1000000000000)
	     return self::terbilang($angka / 1000000000) . ' milyar' . self::terbilang(fmod($angka,1000000000));
	   elseif ($angka < 1000000000000000)
	     return self::terbilang($angka / 1000000000000) . ' trilyun' . self::terbilang(fmod($angka,1000000000000));
	}

    /**
     * Convert number to accounting format
     *
     * @param int $number
     * @param string $numberDelimiter
     * @param string $decimalDelimiter
     *
     * @return string
     */
    static public function accountingFormat($number, $numberDelimiter = '.', $decimalDelimiter = ',')
    {
        if ($number == 0) return '-';

        if ($number < 0) return sprintf('(%s)', number_format(abs($number), 2, $decimalDelimiter, $numberDelimiter));

        return number_format($number, 2, $decimalDelimiter, $numberDelimiter);
    }
}
