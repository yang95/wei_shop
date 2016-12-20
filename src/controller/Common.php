<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:31
 */

namespace WEI\Controller;


class Common
{
    private $Container;

    /**
     * 注入容器
     * @param $iA
     */
    public function __INIT__($iA)
    {
        $this->Container = $iA;
    }

    /**
     * 加载配置
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
     * 实例控制类
     * @param $iSub
     * @param $iClass
     * @param $func
     *
     * @return int
     */
    public function instance($iSub, $iClass, $func)
    {
        $aClass = sprintf("WEI\\Controller\\%s\\%s", $iSub, $iClass);
        if (class_exists($aClass)) {
            /** @var Common $iObj */
            $iObj = new $aClass;
            #注入容器
            $iObj->__INIT__($this->Container);
        } else {
            goto END;
        }
        if (method_exists($iObj, $func)) {
            call_user_func(
                [$iObj, $func]
            );
        } else {
            goto END;
        }
        return 0;
        END:
        exit("access deny");
    }

    /**
     * 获取领域模拟模型
     * @param $iSub
     * @param $iClass
     * @param $func
     *
     * @return int
     */
    public function domain($iSub, $iClass, $func){
        $aClass = sprintf("WEI\\Controller\\Domain\\%s\\%s", $iSub, $iClass);
        if (class_exists($aClass)) {
            /** @var Common $iObj */
            $iObj = new $aClass;
            #注入容器
            $iObj->__INIT__($this->Container);
        } else {
            goto END;
        }
        if (method_exists($iObj, $func)) {
            call_user_func(
                [$iObj, $func]
            );
        } else {
            goto END;
        }
        return 11;
        END:
        return 0;
    }


    /**
     * 构造url地址
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
}