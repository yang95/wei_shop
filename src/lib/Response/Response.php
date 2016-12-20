<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 12:40
 */

namespace WEI\Lib\Response;


class Response
{
    public function location($url)
    {
        header("Location: $url");
    }
    public function nocache()
    {
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache'); //兼容http1.0和https
    }
    public function json($data)
    {
        header("Content-type: application/json; charset=utf-8");
        echo $data;
    }

    public function html($data){
        header('Content-Type: text/html; charset=utf-8');
        echo $data;
    }
}