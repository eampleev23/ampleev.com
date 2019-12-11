<?php


namespace App;


class MyTime
{

    public static function new_time($date)
    { // преобразовываем время в нормальный вид
        $a = strtotime($date);
        $ndate = date('d.m.Y', $a);
        $ndate_time = date('H:i', $a);
        $ndate_exp = explode('.', $ndate);
        $nmonth = array(
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
            12 => 'декабря'
        );

        foreach ($nmonth as $key => $value) {
            if ($key == intval($ndate_exp[1])) {
                $nmonth_name = $value;
            }
        }

        if ($ndate == date('d.m.Y')) {
            return 'сегодня в ' . $ndate_time;
        } elseif ($ndate == date('d.m.Y', strtotime('-1 day'))) {
            return 'вчера в ' . $ndate_time;
        } else {
            return $ndate_exp[0] . ' ' . $nmonth_name . ' ' . $ndate_exp[2] . ' в ' . $ndate_time;
        }
    }

}