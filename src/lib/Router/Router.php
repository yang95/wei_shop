<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:01
 */

namespace WEI\Lib\Router;

use WEI\Controller\RestCommon;
use WEI\Lib\Error\Error;
use WEI\Lib\Response\Response;

class Router implements RouterInterface
{
    public $Container;

    public function Run($Container)
    {
        $tag    = "/";
        $uri    = $_SERVER["REQUEST_URI"];
        $iParam = parse_url($uri);
        $iParam = explode("/", $iParam["path"]);
        if ($iParam[1] != "v1") {
            goto END;
        }
        $iSub   = isset($iParam[2]) ? $iParam[2] : "Home";
        $iClass = isset($iParam[3]) ? $iParam[3] : "Index";
        $aClass = sprintf("WEI\\Controller\\%s\\%s", $iSub, $iClass);
        if (class_exists($aClass)) {
            /** @var RestCommon $iObj */
            $iObj = new $aClass;
            if ($iObj instanceof RestCommon) {
                #注入容器
                $iObj->__INIT__($Container);
            } else {
                goto END;
            }
        } else {
            goto END;
        }
        if (isset($iParam[4]) && substr($iParam[4], -7) == ".action") {
            $func = substr($iParam[4], 0, -7);
            if (method_exists($iObj, $func)) {
                call_user_func(
                    [$iObj, $func]
                );
            } else {
                goto END;
            }
        } else {
            goto END;
        }
        return 0;
        END:
        /** @var Response $RESP */
        $RESP = $Container["Response"];
        $RESP->finish(Error::ERR_ROUTE, "access deny");
        return -11;
    }
}