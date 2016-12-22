<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:20
 */

namespace WEI\Domain\User;


use WEI\Domain\Common\DomainCommon;

class UserService extends DomainCommon implements UserInterface
{
    /**
     * @param $name
     * @param $password
     *
     * @return int|UserItem
     */
    public function getUserByNamePassword($name, $password)
    {
        $crypt = $this->load("Crypt");
        $db    = $this->load("Mysql");
        $iData = $db->select("wei_user", "*", ["name[=]" => $name, "password[=]" => $crypt->encode($password)]);
        if (isset($iData[0])) {
            $id = $iData[0]["id"];
        } else {
            $id = 0;
        }
        return $this->getUserById($id);
    }

    /**
     * @param $openid
     *
     * @return int|UserItem
     */
    public function getUserByOpenid($openid)
    {
        $db    = $this->load("Mysql");
        $iData = $db->select("wei_user", "*", ["openid[=]" => $openid]);
        if (isset($iData[0])) {
            $id = $iData[0]["id"];
        } else {
            $id = 0;
        }
        return $this->getUserById($id);
    }

    /**
     * @param $id
     *
     * @return int|UserItem
     */
    public function getUserById($id)
    {
        $db    = $this->load("Mysql");
        $iData = $db->select("wei_user", "*", ["id[=]" => $id]);
        if (isset($iData[0])) {
            $tmp = $iData[0];
            $c   = new UserItem($tmp["id"], $tmp["openid"], $tmp["name"], $tmp["password"], $tmp["rank"]);
            $c->__INIT__($this->Container);
            return $c;
        } else {
            return 0;
        }
    }
}