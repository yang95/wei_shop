<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:25
 */

namespace WEI\Controller\Home;


use WEI\Controller\Common;

class Index extends Common
{
    public function run()
    {
        $log = $this->load("Log");
        $log->debug("123");
        echo "hello index";
    }
    public function ido(){
        $db   = $this->load("Mysql");
        $a =  $db->select("wp_posts","*",["id[=]"=>1]);
        var_dump($a);
    }
}