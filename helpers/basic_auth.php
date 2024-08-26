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
    function basic_auth_force_logout_link($begin = '', $end = ''): string
    {
        return $begin . '<a href="#" onclick="forceLogoutBasicAuth(); return false;">Logout</a>' . $end;
    }
}
