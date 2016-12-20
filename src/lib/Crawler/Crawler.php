<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/19
 * Time: 23:54
 */

namespace WEI\Lib\Crawler;


class Crawler implements CrawlerInterface
{
    /**
     * @param $url
     * @param $sCB
     * @param $eCB
     */
    public function doOneTask($url,$sCB,$eCB){
        $sBody = file_get_contents($url, false, stream_context_create(
            [
                'http' => ['method' => 'GET', 'timeout' => 5]
            ]
        ));
        if(empty($eCB)){
            call_user_func($eCB);
        }else{
            call_user_func($eCB,$sBody);
        }
    }
}