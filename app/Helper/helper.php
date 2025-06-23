<?php

use App\Models\Setting;
use Carbon\Carbon;

// Currency Formats
if (!function_exists('currency_formats')) {
    function currency_formats()
    {
        return [
            '12300000.50'    => '12300000.50',
            '1,23,000,00.50' => '1,23,000,00.50',
            '123,000,00.50'  => '123,000,00.50',
            '123.000.00,50'  => '123.000.00,50',
            '123,000,00.50'  => '123,000,00.50',
            '123 000 00,50'  => '123 000 00,50',
            '123 000 00.50'  => '123 000 00.50',
            '12300000'       => '12300000',
        ];
    }
}

// Symbol Position
if (!function_exists('symbol_positions')) {
    function symbol_positions()
    {
        return [
            '₹123,000.00'    => '₹123,000.00',
            '123,000.00₹'    => '123,000.00₹',
            '₹ 123,000.00'   => '₹ 123,000.00',
            '123,000.00 ₹'   => '123,000.00 ₹',
            'INR 123,000.00' => 'INR 123,000.00',
            '123,000.00 INR' => '123,000.00 INR',
        ];
    }
}

// Date Format
if (!function_exists('date_formats')) {
    function date_formats()
    {
        return [
            'Y-m-d'  => 'yyyy-mm-dd',
            'Y/m/d'  => 'yyyy/mm/dd',
            'Y.m.d'  => 'yyyy.mm.dd',
            'd-M-Y' => 'dd-mmm-yyyy',
            'd/M/Y' => 'dd/mmm/yyyy',
            'd.M.Y' => 'dd.mmm.yyyy',
            'd-m-Y'  => 'dd-mm-yyyy',
            'd/m/Y'  => 'dd/mm/yyyy',
            'd.m.Y'  => 'dd.mm.yyyy',
            'm-d-Y'  => 'mm-dd-yyyy',
            'm/d/Y'  => 'mm/dd/yyyy',
            'm.d.Y'  => 'mm.dd.yyyy',
        ];
    }
}

function gs()
{
    $general = Cache::get('GeneralSetting');
    if (!$general) {
        $general = (object) Setting::pluck('value', 'key')->toArray(); 
        Cache::put('GeneralSetting', $general);
    }
    return $general; 
}

function showDateTime($date)
{
    $general = gs();
    $format = $general->date_format??'Y-m-d';
    if (!$date) {
        return '-';
    }
    return Carbon::parse($date)->translatedFormat($format);
}


if (!function_exists('showAmount')) {
    function showAmount($amount)
    {
        $general = gs();
        $format = $general->currency_format ?? '12300000.00';
        $symbolFormat = $general->symbol_position ?? '₹123,000.00';
        $symbol = $general->currency_symbol ?? '₹';
        $currency = $general->currency ?? 'INR';

        $amount = number_format((float)$amount, 2, '.', '');
        [$int, $dec] = explode('.', $amount);

        $formatted = '';

        switch ($format) {
            case '12300000.50':
                $formatted = $int . '.' . $dec;
                break;

            case '1,23,000,00.50':
                $formatted = formatCustomGrouping($int, ',', [2, 3, 2]) . '.' . $dec;
                break;

            case '123,000,00.50':
                $formatted = formatCustomGrouping($int, ',', [2, 3, 3]) . '.' . $dec;
                break;

            case '123.000.00,50':
                $formatted = formatCustomGrouping($int, '.', [2, 3, 3]) . ',' . $dec;
                break;

            case '123 000 00,50':
                $formatted = formatCustomGrouping($int, ' ', [2, 3, 3]) . ',' . $dec;
                break;

            case '123 000 00.50':
                $formatted = formatCustomGrouping($int, ' ', [2, 3, 3]) . '.' . $dec;
                break;

            case '12300000':
                $formatted = $int;
                break;

            default:
                $formatted = number_format((float)$amount, 2, '.', ',');
        }

        $final = str_replace('123,000.00', $formatted, $symbolFormat);
        $final = str_replace('₹', $symbol, $final);
        $final = str_replace('INR', $currency, $final);

        return $final;
    }

    function formatCustomGrouping($num, $separator, $grouping)
    {
        $rev = strrev($num);
        $res = '';
        $i = 0;
        $pos = 0;

        while ($pos < strlen($rev)) {
            $groupLen = $grouping[min($i, count($grouping) - 1)];
            if ($pos != 0) $res .= $separator;
            $res .= substr($rev, $pos, $groupLen);
            $pos += $groupLen;
            $i++;
        }

        return strrev($res);
    }
}


