<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/22
 * Time: 14:37
 */

namespace WEI\Controller\Tool;


use WEI\Controller\RestCommon;
use WEI\Lib\Error\Error;

class Qiniu extends RestCommon
{
    public function auth()
    {
        $qi = $this->load("Qiniu");
        $this->finish(Error::ERR_NONE, $qi);
    }
}