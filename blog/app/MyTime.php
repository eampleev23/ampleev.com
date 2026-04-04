<?php


namespace App;

use App\Support\SiteLocale;

class MyTime
{

    public static function new_time($date)
    { // преобразовываем время в нормальный вид
        $a = strtotime($date);
        $ndate = date('d.m.Y', $a);
        $ndate_time = date('H:i', $a);
        $ndate_exp = explode('.', $ndate);
        $isEn = SiteLocale::resolve(request()) === SiteLocale::EN;
        $nmonth = $isEn ? self::enMonths() : self::ruMonths();

        foreach ($nmonth as $key => $value) {
            if ($key == intval($ndate_exp[1])) {
                $nmonth_name = $value;
            }
        }

        if ($ndate == date('d.m.Y')) {
            return ($isEn ? 'today at ' : 'сегодня в ') . $ndate_time;
        } elseif ($ndate == date('d.m.Y', strtotime('-1 day'))) {
            return ($isEn ? 'yesterday at ' : 'вчера в ') . $ndate_time;
        } else {
            $day = (string) intval($ndate_exp[0]);
            return $day . ' ' . $nmonth_name . ' ' . $ndate_exp[2] . ($isEn ? ' at ' : ' в ') . $ndate_time;
        }
    }

    public static function new_day($date)
    {
        // формат как в new_time, но без "в HH:MM"
        $a = strtotime($date);
        $ndate = date('d.m.Y', $a);
        $ndate_exp = explode('.', $ndate);
        $isEn = SiteLocale::resolve(request()) === SiteLocale::EN;
        $nmonth = $isEn ? self::enMonths() : self::ruMonths();

        foreach ($nmonth as $key => $value) {
            if ($key == intval($ndate_exp[1])) {
                $nmonth_name = $value;
            }
        }

        if ($ndate == date('d.m.Y')) {
            return $isEn ? 'today' : 'сегодня';
        } elseif ($ndate == date('d.m.Y', strtotime('-1 day'))) {
            return $isEn ? 'yesterday' : 'вчера';
        }

        $day = (string) intval($ndate_exp[0]);
        $formattedDate = $day . ' ' . $nmonth_name;

        if ($a < strtotime('-1 year')) {
            $formattedDate .= ' ' . $ndate_exp[2];
        }

        return $formattedDate;
    }

    private static function ruMonths(): array
    {
        return [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря',
        ];
    }

    private static function enMonths(): array
    {
        return [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
    }

}
