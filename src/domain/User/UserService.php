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
        $iData = $db->get("wei_user", "*", ["AND"=>[
            "name[=]" => $name,
            "password[=]" => $password ]
        ]);
        if (isset($iData)) {
            $id = $iData["id"];
        } else {
            $id = 0;
        }
        return $this->getUserById($id);
    }
    public function userNameExist($name){
        $db    = $this->load("Mysql");
        $iData = $db->get("wei_user", "*", ["name[=]" => $name]);
        if (isset($iData)) {
            $id = $iData["id"];
        } else {
            $id = 0;
        }
        return $id;
    }

    /**
     * @param $openid
     *
     * @return int|UserItem
     */
    public function getUserByOpenid($openid)
    {
        $db    = $this->load("Mysql");
        $iData = $db->get("wei_user", "*", ["openid[=]" => $openid]);
        if (isset($iData)) {
            $id = $iData["id"];
        } else {
            $id = 0;
        }
        return $this->getUserById($id);
    }

    /**
     * 获取user
     * @param $id
     *
     * @return int|UserItem
     */
    public function getUserById($id)
    {
        $db    = $this->load("Mysql");
        $iData = $db->get("wei_user", "*", ["id[=]" => $id]);
        if (isset($iData) && isset($iData["id"])) {
            $tmp = $iData;
            $c   = $this->buildUser($tmp);
            return $c;
        } else {
            return 0;
        }
    }
    /**
     * 构造user
     *
     * @param $tmp
     *
     * @return UserItem
     */
    public function buildUser($tmp)
    {
        $c = new UserItem();
        if(isset($tmp["id"])){
            $c->setId($tmp["id"]);
        }
        if(isset($tmp["openid"])){
            $c->setOpenid($tmp["openid"]);
        }
        if(isset($tmp["name"])){
            $c->setName($tmp["name"]);
        }
        if(isset($tmp["password"])){
            $c->setPassword($tmp["password"]);
        }
        if(isset($tmp["rank"])){
            $c->setRank($tmp["rank"]);
        }
        if(isset($tmp["phone"])){
            $c->setPhone($tmp["phone"]);
        }
        if(isset($tmp["email"])){
            $c->setEmail($tmp["email"]);
        }
        if(isset($tmp["valid_phone"])){
            $c->setValidPhone($tmp["valid_phone"]);
        }
        if(isset($tmp["valid_email"])){
            $c->setValidEmail($tmp["valid_email"]);
        }
        $c->__INIT__($this->Container);
        return $c;
    }

}