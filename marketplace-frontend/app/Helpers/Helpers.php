<?php

/**
 * ROMS - Helpers
 */

if (!function_exists('roms_temp')) {
    function roms_temp()
    {
        echo 'roms_temp ';
    }
}

/**
 *
 */
if (!function_exists('romsStoreTime')) {
    function romsStoreTime($time)
    {
        return date('g:i a', strtotime($time));
    }
}

/**
 * Show a single product
 *
 * Heper function - Required..
 * Impact: High
 */

if (!function_exists('romsShowProduct')) {
    function romsShowProduct($product = [])
    {
        return $product['name'];
    }
}

/**
 * Print price with currency
 *
 * Helper function
 * Impact : High
 */

if (!function_exists('romsProPrice')) {
    function romsProPrice($price = '', $space = true)
    {
        return $price;   
        //return config('roms.system.currency') . (($space) ? ' ' : '') . $price;
    }
}

/**
 * romsBoolColumn
 *
 */

if (!function_exists('romsBoolColumn')) {
    function romsBoolColumn($column, $attributeName = 'active')
    {
        if (isset($column)) {
            if ($column[$attributeName]) {
                return "<span class='badge badge-success'>" . trans('front.yes') . "</span>";
            } else {
                return "<span class='badge badge-danger'>" . trans('front.no') . "</span>";
            }
        }
    }
}


/**
 * @param $modelObject
 * @param string $attributeName
 * @return null|string|string[]
 */
function romsDateColumn($modelObject, $attributeName = 'updated_at')
{
    if (setting('is_human_date_format', false)) {
        $html = '<p data-toggle="tooltip" data-placement="bottom" title="${date}">${dateHuman}</p>';
    } else {
        $html = '<p data-toggle="tooltip" data-placement="bottom" title="${dateHuman}">${date}</p>';
    }
    if (!isset($modelObject[$attributeName])) {
        return '';
    }
    $dateObj = new Carbon\Carbon($modelObject[$attributeName]);
    $replace = preg_replace('/\$\{date\}/', $dateObj->format(setting('date_format', 'l jS F Y (h:i:s)')), $html);
    $replace = preg_replace('/\$\{dateHuman\}/', $dateObj->diffForHumans(), $replace);
    return $replace;
}