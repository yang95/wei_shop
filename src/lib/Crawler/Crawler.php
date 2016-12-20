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
     *
     * @return mixed
     */
    public function doOneTask($url, $sCB, $eCB = null)
    {
        set_error_handler(
            create_function(
                '$severity, $message, $file, $line',
                'throw new ErrorException($message, $severity, $severity, $file, $line);'
            )
        );
        try {
            $sBody = file_get_contents($url, false, stream_context_create(
                [
                    'http' => ['method' => 'GET', 'timeout' => 5]
                ]
            ));
        } catch (\Exception $e) {
            return -1;
        }

        restore_error_handler();
        return call_user_func($sCB, $sBody);
    }
}