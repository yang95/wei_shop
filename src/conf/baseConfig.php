<?php

use WEI\Lib\Crawler\Crawler;
use WEI\Lib\Request\Request;
use WEI\Lib\Response\Response;
use WEI\Lib\Router\Router;

date_default_timezone_set('Asia/Shanghai');

define("CONF_DIR_POSITIOON_WEI", __dir__);
return array_merge_recursive(
    [
        "Request"  => function () {
            return new Request();
        },
        "Response" => function () {
            return new Response();
        },
        "Router"   => function () {
            return new Router();
        },
        "Cli"      => function () {
            return new WEI\Lib\Cli\Cli();
        },
        "Crypt"    => function () {
            return new WEI\Lib\Crypt\Crypt();
        },
        "Crawler"  => function () {
            return new Crawler();
        }
    ],
    require_once(CONF_DIR_POSITIOON_WEI . "/extendConfig.php")
);
