<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:25
 */

namespace WEI\Controller\Home;


use WEI\Controller\Common;
use WEI\Lib\Error\Error;

class Index extends Common
{
    public function run()
    {
        $log = $this->load("Log");
        $log->debug("123");
        echo "hello index";
    }

    public function ido()
    {
        $d   = $this->load("Crawler");
        $url = "http://www.yangakw.cn";
        $sCB = function ($param) {
            return $param;
        };
        $iData = $d->doOneTask($url, $sCB);
        $this->finish(Error::ERR_NONE, $iData);
    }
}