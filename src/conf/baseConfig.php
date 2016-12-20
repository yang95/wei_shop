<?php
namespace WEI\Conf;
use WEI\Controller\Common;
use WEI\Lib\Container\Container;
use WEI\Lib\Log\Log;
use WEI\Lib\Router\Router;

date_default_timezone_set('Asia/Shanghai');
return [
    "Mysql"=>function(){
        $database = new \medoo([
            'database_type' => 'mysql',
            'database_name' => 'yangakw',
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ]);
        return $database;
    },
    "Log"=>function(){
        $log = new Log(ROOT."/public/log/".date("Y-m-d").".log");
        return $log;
    },
    "Router"=>function(){
        return new Router();
    },
    "test"=>function(){
        echo "test";
    }
];