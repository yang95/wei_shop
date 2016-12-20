<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:27
 */

namespace WEI\Lib\Error;


class Error
{
    const ERR_NONE = 1000;

    public static $MSG = [
        -1             => '未知错误',
        self::ERR_NONE => "",
    ];

    public static function getErr($iErr)
    {
        return isset(self::$MSG[$iErr]) ? self::$MSG[$iErr] : self::$MSG[-1];
    }
}