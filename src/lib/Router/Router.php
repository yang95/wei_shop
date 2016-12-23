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
use WEI\Lib\Log\Log;
use WEI\Lib\Response\Response;

class Router implements RouterInterface
{
    public function Run($Container)
    {
        $uri    = $_SERVER["REQUEST_URI"];
        #log debug
        $debug_log = function() use ($Container,$uri){
            /** @var Log $log */
            $log = $Container["Log"];
            $log->debug(
                sprintf("%s\t\t\t%s"
                    ,$uri
                    ,json_encode($_REQUEST)
                )
            );
        };
        $debug_log();
        #log debug end
        $iParam = parse_url($uri);
        $iParam = explode("/", $iParam["path"]);
        #没有uri重写的情况
        if ($iParam[1] == "index.php") {
            array_shift($iParam);
        }
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
            $func = $func."Action";
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