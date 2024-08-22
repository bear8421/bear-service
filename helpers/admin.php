<?php

if (!function_exists('apply_url_link')) {
    function apply_url_link($name = '', $link = '', $ext = ''): string
    {
        $str = trim($name) . ': ';
        $title = 'title="Click here to tools: ' . trim($name) . '"';
        $str .= '<a ' . $title . ' href="' . trim($link) . '" target="_blank">' . trim($link) . '</a>';
        $str = trim($str);
        if (!empty($ext)) {
            if (extension_loaded('redis')) {
                return $str;
            } else {
                return '';
            }
        }
        return $str;
    }
}
if (!function_exists('apply_li_url_link')) {
    function apply_li_url_link($name = '', $link = '', $ext = ''): string
    {
        $str = apply_url_link($name, $link, $ext);
        if (!empty($str)) {
            return '<li>' . $str . '</li>';
        }
        return '';
    }
}
