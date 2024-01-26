<?php

if (! function_exists('formatBytes'))
{
    /**
     * Format bytes to kb, mb, gb, tb
     *
     * @param  integer $size
     * @param  integer $precision
     * @return integer
     */
    function formatBytes($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        } else {
            return $size;
        }
    }
}

if (! function_exists('cookiesAccepted')) {
    /**
     * Comprobamos si las cookies indicadas están aceptadas por el usuario
     *
     * @param $type
     * @return bool
     */
    function cookiesAccepted($type) {
        $gya_cookies = isset($_COOKIE['gya_cookies']) ? $_COOKIE['gya_cookies'] : null;

        if ($gya_cookies != null && $gya_cookies != '') {
            $cookies_accepted = json_decode($gya_cookies)->cookies;
            if (in_array($type, $cookies_accepted))
                return true;
            else
                return false;
        }
        return false;
    }
}
