<?php

if (!function_exists('basic_auth_force_logout_script')) {
    function basic_auth_force_logout_script(): string
    {
        // Return the JavaScript code
        return <<<JAVASCRIPT
<script>
    function forceLogoutBasicAuth() {
        var fakeURL = window.location.protocol + "//logout:logout@" + window.location.host;
        var logoutWindow = window.open(fakeURL, "_self");
        logoutWindow.close();
    }
</script>
JAVASCRIPT;
    }
}
if (!function_exists('basic_auth_force_logout_link')) {
    function basic_auth_force_logout_link($tag = ''): string
    {
        $openTag = '';
        $closeTag = '';
        if (!empty($tag)) {
            $openTag = '<' . trim($tag) . '>';
            $closeTag = '</' . trim($tag) . '>';
        }
        return $openTag . '<a href="#" onclick="forceLogoutBasicAuth(); return false;">Logout</a>' . $closeTag;
    }
}
