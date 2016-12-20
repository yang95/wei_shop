<?php
define("ROOT", __dir__);
require_once(ROOT . "/vendor/autoload.php");
$main = function ($debug) {
    $app = \WEI\Lib\Container\Container::__INIT__(
        require_once(ROOT . "/src/Conf/baseConfig.php")
    );
    $router = $app["Router"];
    $app["Log"]->setDebug($debug);
    $router->run($app);
};
$debug = true;#开启debug
$main($debug);