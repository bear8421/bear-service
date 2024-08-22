<?php

if (!function_exists('powered_by_author')) {
    function powered_by_author($startYear = ''): string
    {
        if (empty($startYear)) {
            $copyYear = date('Y');
        } else {
            $copyYear = $startYear . '-' . date('Y');
        }

        $str = '&copy; ' . $copyYear;
        $str .= ' Hung Nguyen';
        $str .= ' (dev@nguyenanhung.com)';
        $str .= '. All Rights Reserved.';
        return trim($str);
    }
}