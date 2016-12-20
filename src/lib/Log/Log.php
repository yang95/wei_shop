<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/19
 * Time: 23:52
 */

namespace WEI\Lib\Log;


class Log
{
    public $path;
    public $debug = 0;


    public function __construct($p)
    {
        $this->path  = $p;
    }
    public function setDebug($debug){

        $this->debug = $debug;
    }

    public function log($type, $msg, $date, $sub = null, $ig = null)
    {
        $f   = fopen($this->path, "a+");
        $str = sprintf("%s\t\t%s\t\t%s\t\t%s\t\t%s\t\n",
            $type,
            $sub,
            $msg,
            $ig,
            $date
        );
        fwrite($f, $str);
        fclose($f);
    }

    public function error($msg)
    {
        $this->log("error", $msg, date("Y-m-d H:i:s"));
    }

    public function debug($msg)
    {
        if($this->debug){
            $this->log("debug", $msg, date("Y-m-d H:i:s"));
        }
    }

    public function notice($msg)
    {
        $this->log("notice", $msg, date("Y-m-d H:i:s"));
    }
}