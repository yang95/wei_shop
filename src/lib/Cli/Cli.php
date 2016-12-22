<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:01
 */

namespace WEI\Lib\Cli;


use WEI\Console\CliCommon;

class Cli implements CliInterface
{
    public $Container;

    public function Run($Container)
    {
        $iParam = getopt("s:c:f:p:");
        if (!isset($iParam["s"]) && !isset($iParam["c"]) && !isset($iParam["f"])) {
            goto END;
        }
        $iSub   = $iParam["s"];
        $iClass = $iParam["c"];
        $func   = $iParam["f"];
        $param  = isset($iParam["p"])?$iParam["p"]:'';
        $aClass = sprintf("WEI\\Console\\%s\\%s", $iSub, $iClass);
        if (class_exists($aClass)) {
            /** @var CliCommon $iObj */
            $iObj = new $aClass;
            if ($iObj instanceof CliCommon) {
                #注入容器
                $iObj->__INIT__($Container);
            } else {
                exit("$aClass not instanceof CliCommon \n");
            }
        } else {
            exit("$aClass not exist\n");
        }
        if (method_exists($iObj, $func)) {
            call_user_func(
                [$iObj, $func],
                $param
            );
        } else {
            exit("$aClass exist but $func not exist\n");
        }
        return 0;
        END:
        exit("php index.php -s -c -f -p\n");
        return -11;
    }
}