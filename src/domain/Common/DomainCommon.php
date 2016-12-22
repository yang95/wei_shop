<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:23
 */

namespace WEI\Domain\Common;


class DomainCommon
{
    protected $Container;

    /**
     * 注入容器
     *
     * @param $iA
     */
    public function __INIT__($iA)
    {
        $this->Container = $iA;
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
        $aClass = sprintf("WEI\\Domain\\%s\\%s", $iSub, $iClass);
        if (class_exists($aClass)) {
            $iObj = new $aClass;
            if ($iObj instanceof DomainCommon) {
                #注入容器
                $iObj->__INIT__($this->Container);
            } else {
                $iObj = null;
            }
        } else {
            goto END;
        }
        END:
        return $iObj;
    }

}