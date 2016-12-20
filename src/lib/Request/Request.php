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
}