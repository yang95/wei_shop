<?php
define("ROOT", __dir__);
require_once(ROOT . "/vendor/autoload.php");
$main  = function ($debug) {
    $app = \WEI\Lib\Container\Container::__INIT__(
        require_once(ROOT . "/src/Conf/baseConfig.php")
    );
    $app["Log"]->setDebug($debug);
    if (substr(php_sapi_name(), 0, 3) == 'cli') {
        $cli = $app["Cli"];
        $cli->run($app);
    } else {
        $router = $app["Router"];
        $router->run($app);
    }
};
$debug = true;#开启debug

#php index.php -s Reflact -c Reflact -f run 在doc/Interface/下查看文档
$main($debug);