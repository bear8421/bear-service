<?php

if (!function_exists('apply_url_link')) {
    function apply_url_link($name = '', $link = ''): string
    {
        $str = trim($name) . ': ';
        $title = 'title="Click here to tools: ' . trim($name) . '"';
        $str .= '<a ' . $title . ' href="' . trim($link) . '" target="_blank">' . trim($link) . '</a>';
        return trim($str);
    }
}

if (!function_exists('admin_apply_url_link')) {
    function admin_apply_url_link($name = '', $link = ''): string
    {
        return '<li>' . apply_url_link($name, $link) . '</li>';
    }
}

if (!function_exists('admin_apply_url_link_required_ext')) {
    function admin_apply_url_link_required_ext($name = '', $link = '', $ext = ''): string
    {
        if (empty($ext)) {
            return '';
        }
        if (extension_loaded($ext)) {
            return admin_apply_url_link($name, $link);
        }
    }
}
