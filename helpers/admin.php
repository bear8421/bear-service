<?php

if (!function_exists('apply_url_link')) {
    function apply_url_link($name = '', $link = ''): string
    {
        $str = trim($name) . ': ';
        $str .= '<a href="' . trim($link) . '" target="_blank">' . trim($link) . '</a>';
        return trim($str);
    }
}
if (!function_exists('generateHtpasswdPassword')) {
    function generateHtpasswdPassword($plainTextPassword): string
    {
        // Tạo salt ngẫu nhiên cho bcrypt (2y) hoặc MD5 ($1$)
        $cost = 12;
        $salt = substr(sha1(date('YmdHisu') . generate_uuid_v4()), 0, 22);

        // Mã hóa mật khẩu với bcrypt
        $hashedPassword = crypt($plainTextPassword, '$2y$' . $cost . '$' . $salt . '$');

        // Kiểm tra nếu hệ thống hỗ trợ bcrypt
        if (strlen($hashedPassword) < 60) {
            // Nếu không hỗ trợ bcrypt, fallback to MD5
            $hashedPassword = crypt($plainTextPassword, '$1$' . $salt . '$');
        }

        return $hashedPassword;
    }
}
