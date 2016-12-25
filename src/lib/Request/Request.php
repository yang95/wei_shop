<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 12:45
 */

namespace WEI\Lib\Request;

class Request
{
    public function request($arg = null)
    {
        $i_v = $_REQUEST;
        if (empty($arg)) {
            return $i_v;
        } else {
            return isset($i_v[$arg]) ? $i_v[$arg] : -1;
        }
    }

    public function post($arg = null)
    {
        $i_v = $_POST;
        if (empty($arg)) {
            return $i_v;
        } else {
            return isset($i_v[$arg]) ? $i_v[$arg] : -1;
        }
    }

    public function get($arg = null)
    {
        $i_v = $_GET;
        if (empty($arg)) {
            return $i_v;
        } else {
            return isset($i_v[$arg]) ? $i_v[$arg] : -1;
        }
    }

    public function cookie($key, $value = null, $rm = 0)
    {
        if (!empty($value)) {
            $value = base64_encode($value);
            setcookie($key, $value, time() + 3600 * 24 * 7, "/");
        }
        $value = isset($_COOKIE[$key]) ? $_COOKIE[$key] : 0;
        $value = base64_decode($value);
        if ($rm) {
            setcookie($key, $value, time() - 60, "/");
        }
        return $value;
    }
}