<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/25
 * Time: 14:45
 */
namespace WEI\Lib\Wechat;

class Wechat
{
    public $appid     = '';
    public $appsercet = '';

    /**
     * Wechat constructor.
     *
     * @param string $appid
     * @param string $appsercet
     */
    public function __construct($appid, $appsercet)
    {
        $this->appid     = $appid;
        $this->appsercet = $appsercet;
    }

    public function redict()
    {
        return sprintf("%s/%s/%s",
            "https://wechat.com",
            $this->appid,
            $this->appsercet
        );
    }
}