<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:31
 */

namespace WEI\Controller;


use WEI\Domain\Common\DomainCommon;
use WEI\Domain\User\UserItem;
use WEI\Domain\User\UserService;
use WEI\Lib\Error\Error;
use WEI\Lib\Request\Request;
use WEI\Lib\Response\Response;

class RestCommon
{

    const UID = "weiUkey";

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

    public function finish($Err, $iData)
    {
        $this->RSP->finish($Err, $iData);
    }


    /**
     * 用户是否登陆
     *
     * @return mixed
     */
    protected function getUser()
    {
        /** @var UserService $UserService */
        $UserService = $this->domain("User", "UserService");
        $User_id     = $this->REQ->cookie(self::UID);
        $User        = $UserService->getUserById($User_id);
        if ($User instanceof UserItem) {
            return $User;
        }
        $this->finish(Error::ERR_LOGIN, '');
        exit();
    }
}