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
    const ERR_NONE  = 0;
    const ERR_ROUTE  = 11;
    const ERR_LOGIN = 1000;
    const ERR_PARAM = 1001;

    public static $MSG = [
        -1              => '未知错误',
        self::ERR_NONE  => "",
        self::ERR_ROUTE  => "404",
        self::ERR_LOGIN => "未登陆",
        self::ERR_PARAM => "参数错误",
    ];

    public static function getErr($iErr)
    {
        return isset(self::$MSG[$iErr]) ? self::$MSG[$iErr] : self::$MSG[-1];
    }
}