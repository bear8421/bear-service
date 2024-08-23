<?php

use nguyenanhung\PhpBasicFirewall\CheckSystem;

if (!function_exists('quick_check_system')) {
    function quick_check_system(): CheckSystem
    {
        return new CheckSystem();
    }
}
if (!function_exists('quick_check_php_need_environment')) {
    function quick_check_php_need_environment(): array
    {
        // Kiểm tra nhanh các hàm, extension trong dự án
        // Function: các hàm nên tắt
        // Extension: các extension nên bật
        return [
            'functions_to_check' => [
                'openssl_digest',
                'exec',
                'system',
                'shell_exec',
                'passthru',
                'popen',
                'proc_open',
                'fsockopen',
                'pfsockopen',
                'stream_socket_client',
                'stream_socket_server',
                'stream_socket_accept',
                'phpinfo',
                'ini_set',
                'ini_get',
                'putenv',
                'getenv',
                'eval',
                'create_function',
                'assert',
                'preg_replace'
            ],
            'extensions_to_check' => [
                'Zend OPcache',
                'curl',
                'pdo',
                'pdo_mysql',
                'pdo_sqlite',
                'mysqli',
                'gd',
                'mbstring',
                'session',
                'sockets',
                'bcmath',
                'libxml',
                'xml',
                'xmlwriter',
                'xmlreader',
                'openssl',
                'ctype',
                'dom',
                'mcrypt',
                'redis',
                'memcached',
                'gearmand',
                'sodium',
            ],
        ];
    }
}
if (!function_exists('icon_check')) {
    function icon_check($check = false): string
    {
        if ($check === true || $check === 'OK' || $check === 'YES') {
            return '✅ ';
        }
        return '❌ ';
    }
}
if (!function_exists('quick_check_status')) {
    function quick_check_status($check = ''): string
    {
        $status = strtoupper($check['status']);
        if (isset($check['name'])) {
            $name = $check['name'];
        } elseif (isset($check['hostname']) && isset($check['port'])) {
            $name = $check['hostname'] . ':' . $check['port'];
        } else {
            $name = 'Unknown';
        }

        if ($status === 'OK') {
            $status = '<span style="color: blue">Enabled</span>';
            $result = icon_check(true) . $name . ' -> <strong>' . $status . '</strong>';
        } else {
            $status = '<span style="color: red;">Disabled</span>';
            $result = icon_check() . $name . ' -> <strong>' . $status . '</strong>';
        }
        return $result;
    }
}
if (!function_exists('quick_check_php_extension')) {
    /**
     * @param string $ext
     * @return string
     */
    function quick_check_php_extension(string $ext = ''): string
    {
        $ext = trim($ext);
        if (empty($ext)) {
            return "<tr><td>PHP Extension 'Not Found'</td><td>Not Found</td></tr>";
        }
        $check = quick_check_system()->checkExtensionRequirement($ext);
        $result = quick_check_status($check);
        return "<tr><td>PHP Extension '<strong>" . $ext . "</strong>'</td><td>" . $result . "</td></tr>";
    }
}
if (!function_exists('quick_check_php_functions')) {
    /**
     * @param string $function_name
     * @return string
     */
    function quick_check_php_functions(string $function_name = ''): string
    {
        $function_name = trim($function_name);
        if (empty($function_name)) {
            return "<tr><td>PHP Functions 'Not Found'</td><td>Not Found</td></tr>";
        }
        $check = quick_check_system()->checkFunctionsRequirement($function_name);
        $result = quick_check_status($check);
        return "<tr><td>PHP Functions '<strong>" . $function_name . "</strong>'</td><td>" . $result . "</td></tr>";
    }
}
if (!function_exists('quick_check_php_version_compare')) {
    function quick_check_php_version_compare($version = '7.0'): string
    {
        $check = quick_check_system()->setPhpMinVersion($version)->checkPhpVersion();
        $message = $check['message_pattern'];
        $message = str_replace('{{min_version}}', '<strong>' . $check['min_version'] . '</strong>', $message);
        $message = str_replace('{{operator}}', '<strong>' . $check['operator'] . '</strong>', $message);
        if ($check['current_version'] >= $check['min_version']) {
            $current_version = '<strong style="color: blue">' . $check['current_version'] . '</strong>';
            $message = icon_check(true) . str_replace('{{current_version}}', $current_version, $message);
        } else {
            $current_version = '<strong style="color: red;>' . $check['current_version'] . '</strong>';
            $message = icon_check() . str_replace('{{current_version}}', $current_version, $message);
        }
        return "<tr><td>PHP Version Compare</td><td>" . $message . "</td></tr>";
    }
}
if (!function_exists('quick_check_telnet_to_port')) {
    function quick_check_telnet_to_port($host = '127.0.0.1', $port = 3306, $base_url = 'http://localhost:8080/'): string
    {
        $url = parse_url($base_url);
        if (isset($url['host']) && $url['host'] === 'localhost') {
            $result = icon_check() . 'NOK, because on ' . ucfirst($url['host']);
        } else {
            $check = quick_check_system()->connectUsePhpTelnet($host, $port);
            $result = quick_check_status($check);
        }
        return "<tr><td>Test connect '<strong>" . $host . "</strong>' to '<strong>" . $port . "</strong>'</td><td>" . $result . "</td></tr>";
    }
}
if (!function_exists('quick_check_connect_to_database')) {
    function quick_check_connect_to_database($host = '127.0.0.1', $port = 3306): string
    {
        return quick_check_telnet_to_port($host, $port, base_url());
    }
}
