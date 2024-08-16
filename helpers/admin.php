<?php

if (!function_exists('apply_url_link')) {
    function apply_url_link($name = '', $link = ''): string
    {
        $str = trim($name) . ': ';
        $str .= '<a href="' . trim($link) . '" target="_blank">' . trim($link) . '</a>';
        return trim($str);
    }
}
