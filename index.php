<?php
define("ROOT", __dir__);
require_once(ROOT . "/vendor/autoload.php");
$main  = function ($debug) {
    if($debug){
        register_shutdown_function(function(){
            $Error = error_get_last();
            if(!empty($Error)){
                var_dump($Error);
            }
        });
    }
    $app = \WEI\Lib\Container\Container::__INIT__(
        require_once(ROOT . "/src/conf/baseConfig.php")
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
$main($debug);