<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:35
 */

namespace WEI\Controller\User;


use WEI\Controller\RestCommon;
use WEI\Domain\User\UserItem;
use WEI\Domain\User\UserService;
use WEI\Lib\Crypt\Crypt;
use WEI\Lib\Error\Error;

class UserBase extends RestCommon
{
    const UID = "weiUkey";

    /**
     * 注册接口
     * name
     * password
     *
     */
    public function registerAction()
    {
        /** @var Crypt $crypt */
        $crypt            = $this->load("Crypt");
        $iData["sign_in"] = false;
        $param            = $this->REQ->request();
        $param["openid"]  = $this->REQ->cookie("openid");
        if (isset($param["name"]) && isset($param["password"])) {
            $param["password"] = $crypt->password($param["password"]);
            /** @var UserService $UserService */
            $UserService = $this->domain("User", "UserService");
            if ($UserService->userNameExist($param["name"])) {
                goto END;
            }
            $UserItem         = $UserService->buildUser($param);
            $iData["sign_in"] = $UserItem->save();
        }
        return $this->finish(Error::ERR_NONE, $iData);
        END:
        return $this->finish(Error::ERR_VALUE, '');
    }

    /**
     * 登陆接口
     * name
     * password
     */
    public function loginAction()
    {
        /** @var UserService $UserService */
        $UserService = $this->domain("User", "UserService");
        /** @var Crypt $crypt */
        $crypt = $this->load("Crypt");
        $param = $this->REQ->request();
        if (isset($param["name"]) && isset($param["password"])) {
            $name     = $param["name"];
            $password = $crypt->password($param["password"]);
            $userItem = $UserService->getUserByNamePassword($name, $password);
            if ($userItem instanceof UserItem) {
                /**
                 * 登陆成功记录信息
                 */
                $User_id       = $this->REQ->cookie(self::UID, $userItem->getId());
                $data["login"] = true;
            } else {
                $data["login"] = false;
            }
            $this->finish(Error::ERR_NONE, $data);
        } else {
            $this->finish(Error::ERR_PARAM, "");
        }
    }

    /**
     * 用户完善信息
     * password
     *
     */
    public function completeAction()
    {
        $user = $this->getUser();
        /** @var Crypt $crypt */
        $crypt = $this->load("Crypt");
        $param = $this->REQ->request();
        if (isset($param["password"])) {
            $password = $crypt->password($param["password"]);
            $user->setPassword($password);
            $err = $user->save();
            goto END;
        }
        END:
        $this->finish(Error::ERR_NONE, '');

    }

    /**
     * 微信登陆接口
     */
    public function weichatAction()
    {
        #用户是否登陆
        /** @var UserService $UserService */
        $UserService = $this->domain("User", "UserService");
        $User_id     = $this->REQ->cookie(self::UID);
        $User        = $UserService->getUserById($User_id);
        if ($User instanceof UserItem) {
            $this->RSP->location("index");
        } else {
            $url = $this->load("Wechat")->redict();
            $this->RSP->location($url);
        }
    }

    /**
     *
     * 退出登录
     */
    public function logoutAction(){
        #清除cookie
        $User_id     = $this->REQ->cookie(self::UID,'',true);
        $this->finish(Error::ERR_NONE, '');
    }

    /**
     * 用户是否登陆
     *
     * @return mixed
     */
    private function getUser()
    {
        /** @var UserService $UserService */
        $UserService = $this->domain("User", "UserService");
        $User_id     = $this->REQ->cookie(self::UID);
        $User        = $UserService->getUserById($User_id);
        if ($User instanceof UserItem) {
            return $User;
        }
        exit(
        $this->finish(Error::ERR_LOGIN, '')
        );
    }

}