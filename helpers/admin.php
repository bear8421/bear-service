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
if (!function_exists('report_http_connection_message')) {
    function report_http_connection_message(): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $protocol = $_SERVER['SERVER_PROTOCOL'] ?? '';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $port = $_SERVER['SERVER_PORT'] ?? '';
        $serverIP = $_SERVER['SERVER_ADDR'] ?? '';
        $authUser = isset($_SERVER['PHP_AUTH_USER']) ? 'Authorization User: ' . $_SERVER['PHP_AUTH_USER'] . ' - ' : '';
        $serverName = isset($_SERVER['SERVER_NAME']) ? 'Server Name: ' . $_SERVER['SERVER_NAME'] . ' - ' : '';
        $country = isset($_SERVER['HTTP_CF_IPCOUNTRY']) ? ' (' . $_SERVER['HTTP_CF_IPCOUNTRY'] . ')' : '';
        $referer = isset($_SERVER['HTTP_REFERER']) ? ', Referer: ' . $_SERVER['HTTP_REFERER'] : '';
        $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? ', User Agent: ' . $_SERVER['HTTP_USER_AGENT'] : '';
        // Build the log message
        $message = $authUser . $serverName . 'Connection via ' . $protocol . ': ' . $scheme . '://' . $host;
        $message .= ', Port: ' . $port . ', Server IP: ' . $serverIP;
        $message .= ', from IP:' . getIPAddress() . $country;
        $message .= $referer;
        $message .= $userAgent;
        return $message;
    }
}
