<?php

use Bear8421\Bear\Services\Config\Author;

if (!function_exists('powered_by_author')) {
    function powered_by_author($startYear = ''): string
    {
        $str = '&copy; ' . Author::getCopyrightYear($startYear);
        $str .= ' ' . Author::getAuthorName();
        $str .= ' (' . Author::getAuthorEmail() . ')';
        $str .= '. All Rights Reserved.';
        return trim($str);
    }
}