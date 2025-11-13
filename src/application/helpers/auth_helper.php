<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('set_auth_cookie')) {
    function set_auth_cookie($user_data)
    {
        $ci = &get_instance();

        // Encode user data
        $auth_data = base64_encode(json_encode([
            'user_id' => $user_data['id'],
            'username' => $user_data['username'],
            'nama_lengkap' => $user_data['nama_lengkap'],
            'role' => $user_data['role'],
            'department' => $user_data['department'],
            'expires' => time() + AUTH_EXPIRE
        ]));

        // Set cookie
        setcookie(AUTH_COOKIE_NAME, $auth_data, time() + AUTH_EXPIRE, '/', '', false, true);

        return $auth_data;
    }
}

if (!function_exists('get_auth_data')) {
    function get_auth_data()
    {
        if (isset($_COOKIE[AUTH_COOKIE_NAME])) {
            $auth_data = json_decode(base64_decode($_COOKIE[AUTH_COOKIE_NAME]), true);

            // Check expiration
            if ($auth_data && isset($auth_data['expires']) && $auth_data['expires'] > time()) {
                return $auth_data;
            }
        }
        return false;
    }
}

if (!function_exists('clear_auth_cookie')) {
    function clear_auth_cookie()
    {
        setcookie(AUTH_COOKIE_NAME, '', time() - 3600, '/', '', false, true);
        unset($_COOKIE[AUTH_COOKIE_NAME]);
    }
}

if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        return get_auth_data() !== false;
    }
}

if (!function_exists('get_current_user')) {
    function get_current_user()
    {
        return get_auth_data();
    }
}
