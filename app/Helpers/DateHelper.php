<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateTime;

class DateHelper
{
    public static function getDate($date)
    {
        $format = config('constants.date_formats')[config('constants.general.date_format')];
        return date($format, strtotime($date));
    }

    public static function getDateIso8601()
    {
        $isoDate = date(DateTime::ISO8601);
        $character = array("-", "T", ":", "+");
        $isoDate = str_replace($character, "", $isoDate);
        $isoDate = substr($isoDate, 0, 14) . ".0";
        return $isoDate;
    }

    public static function getDateFormat($fecha){
        
        $anio    = substr($fecha,0,4);
        $mes     = substr($fecha,5,2);
        $dia     = substr($fecha,8,2);
                                //
        $fechafin = $dia.'-'.$mes.'-'.$anio;

        return $fechafin;
    }

    public static function getDateForField008()
    {
        $isoDate = date(DateTime::ISO8601);
        $character = array("-", "T", ":", "+");
        $isoDate = str_replace($character, "", $isoDate);
        $isoDate = substr($isoDate, 2, 6);
        return $isoDate;
    }

    public static function getDiferenciaFechasPorDias($fechaInicial, $fechaFinal = null)
    {
        if ($fechaInicial == null)
            return 0;

        if ($fechaFinal == null)
            $fechaFinal = Carbon::now('America/Lima');
        else
            $fechaFinal = new Carbon($fechaFinal);

        $fechaInicial = new Carbon($fechaInicial);


        $format = config('constants.date_formats')[2];
        $fechaInicial = date($format, strtotime($fechaInicial));
        $fechaFinal = date($format, strtotime($fechaFinal));

        $datetime1 = new DateTime($fechaInicial);
        $datetime2 = new DateTime($fechaFinal);

        if ($datetime1 > $datetime2)
            return 0;

        $interval = $datetime1->diff($datetime2);
        $days = $interval->format('%a');

        if ($days > 0)
            return $days;

        return 0;

//        return $fechaInicial . " " . $fechaFinal;
//
//
//        if ($fechaInicial > $fechaFinal)
//            return 0;
//
//        //$diferencia = $fechaInicial->diffInDays($fechaFinal);
//        $diferencia = $fechaInicial->diff($fechaFinal)->days;
//
//        if ($diferencia > 0)
//            return $diferencia;
//
//        return 0;
        //$difference = ($created->diff($now)->days < 1) ? 'today' : $created->diffForHumans($now);


//        $diferencia = (strtotime($fechaDevolucion) - strtotime($fechaFin));
//return strtotime($fechaDevolucion);
//        if ($diferencia > 0)
//            return intval(date('d', $diferencia));

        //return 0;
    }

    public static function isDateTodayYmd($fecha)
    {
        if ($fecha == null)
            return 0;

        $format = config('constants.date_formats')[2];
        if (date($format, strtotime(Carbon::now('America/Lima'))) == date($format, strtotime($fecha)))
            return 1;
        return 0;
    }

    public static function getCurrentDate()
    {
        //$format = config('constants.date_formats')[1];
        //return date($format, strtotime(Carbon::now('America/Lima')));
        return Carbon::now('America/Lima');
    }
}
