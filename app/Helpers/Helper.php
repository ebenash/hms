<?php

namespace App\Helpers;

use Hashids;
use Acaronlex\LaravelCalendar\Calendar;
// use MaddHatter\LaravelFullcalendar\Calendar;

class Helper
{

    public static function sms_message_count($message)
    {
        $smscount = "";
        if(strlen($message > 160)){
            $smscount .= ceil(strlen($message)/153)." SMS Messages ";
        }else{
            $smscount .= ceil(strlen($message)/160)." SMS Messages ";
        }
        $smscount .= strlen($message)." Characters.";
        return $smscount;
    }

    public static function sms_count_only($message)
    {
        $smscount = 0;
        if(strlen($message > 160)){
            $smscount = ceil(strlen($message)/153);
        }else{
            $smscount = ceil(strlen($message)/160);
        }
        return $smscount;
    }

    public static function number_ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public function hash_id_it($number) {
        return Hashids::encode($number);
    }

    public function remove_weird_characters($text) {
        $textArr = str_split($text);
        $newtext = '';
        foreach ($textArr as $Char) {
            $CharNo = ord($Char);
            if ($CharNo == 163) { $newtext .= $Char; continue; } // keep £
            if ($CharNo == 13) { $newtext .= $Char; continue; } // keep \r
            if ($CharNo == 10) { $newtext .= $Char; continue; } // keep \n
            if ($CharNo > 31 && $CharNo < 127) {
                $newtext .= $Char;
            }
        }
        return utf8_encode($newtext);
    }


    public function get_calendar($list) {
        $calendar = new Calendar();
        $calendar->addEvents($list);
        if(auth()->user()->can('add reservations')){
            $calendar->setOptions([
                'locales' => 'FullCalendar.globalLocales',
                'locale' => 'en-gb',
                'firstDay' => 1,
                'displayEventTime' => false,
                'selectable' => true,
                'initialView' => 'dayGridMonth',
                'headerToolbar' => [
                    'left' => 'prev,next today myCustomButton',
                    'center' => 'title',
                    'right' => 'dayGridMonth,dayGridWeek,dayGridDay,listMonth'
                ],
                'customButtons' => [
                    'myCustomButton' => [
                        'text'=> ' Add New Reservation',
                        'click' => 'function() {
                            $("#modal-view-add-reservation").modal("show");
                        }'
                    ]
                ]
            ]);
        }
        return $calendar;
        // window.location.href = "/admin/reservations/create";
    }
}
