<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/19
 * Time: 23:54
 */

namespace WEI\Lib\Crawler;


interface CrawlerInterface
{
    /**
     * @param $url
     * @param $sCB
     * @param $eCB
     *
     */
    public function doOneTask($url,$sCB,$eCB);

}