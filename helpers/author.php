<?php

use Bear8421\Bear\Services\Environment;

if (!function_exists('powered_by_author')) {
    function powered_by_author($startYear = ''): string
    {
        if (empty($startYear)) {
            $copyYear = date('Y');
        } else {
            $copyYear = $startYear . '-' . date('Y');
        }

        $str = '&copy; ' . $copyYear;
        $str .= ' ' . Environment::POWERED_BY_NAME;
        $str .= ' (' . Environment::POWERED_BY_EMAIL . ')';
        $str .= '. All Rights Reserved.';
        return trim($str);
    }
}