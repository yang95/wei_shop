<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:31
 */

namespace WEI\Controller;


use WEI\Lib\Error\Error;
use WEI\Lib\Request\Request;
use WEI\Lib\Response\Response;

class Common
{
    protected $Container;
    /** @var  Request $REQ */
    protected $REQ;
    /** @var  Response $RSP */
    protected $RSP;

    /**
     * 注入容器
     *
     * @param $iA
     */
    public function __INIT__($iA)
    {
        $this->Container = $iA;
        $this->REQ       = $this->load("Request");
        $this->RSP       = $this->load("Response");
    }

    /**
     * 加载配置
     *
     * @param $key
     *
     * @return mixed
     */
    public function load($key)
    {
        if (isset($this->Container[$key])) {
            return $this->Container[$key];
        } else {
            exit("$key not config\n\n");
        }
    }

    /**
     * 获取领域模拟模型
     *
     * @param $iSub
     * @param $iClass
     *
     * @return mixed
     */
    public function domain($iSub, $iClass)
    {
        $iObj   = null;
        $aClass = sprintf("WEI\\Controller\\Domain\\%s\\%s", $iSub, $iClass);
        if (class_exists($aClass)) {
            /** @var Common $iObj */
            $iObj = new $aClass;
            #注入容器
            $iObj->__INIT__($this->Container);
        } else {
            goto END;
        }
        END:
        return $iObj;
    }


    /**
     * 构造url地址
     *
     * @param $iSub
     * @param $iClass
     * @param $func
     *
     * @return string
     */
    public function U($iSub, $iClass, $func)
    {
        return sprintf("/v1/%s/%s/%s.action"
            , $iSub
            , $iClass
            , $func
        );
    }

    public function finish($Err, $iData)
    {
        $out = [
            "code" => $Err,
            "msg"  => Error::getErr($Err),
            "data" => $iData
        ];
        $this->RSP->json(json_encode($out));
    }
}