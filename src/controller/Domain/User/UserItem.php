<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Controller\Domain\User;

use WEI\Controller\Domain\Common\DomainCommon;

class UserItem extends DomainCommon
{
    public $id;
    public $openid;
    public $name;
    public $password;
    public $logo;

    /**
     * UserItem constructor.
     *
     * @param $id
     * @param $openid
     * @param $name
     * @param $password
     * @param $logo
     */
    public function __construct($id, $openid, $name, $password, $logo)
    {
        $this->id       = $id;
        $this->openid   = $openid;
        $this->name     = $name;
        $this->password = $password;
        $this->logo     = $logo;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOpenid()
    {
        return $this->openid;
    }

    /**
     * @param mixed $openid
     */
    public function setOpenid($openid)
    {
        $this->openid = $openid;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     *保存用户
     * @return mixed
     */
    public function save()
    {
        $db = $this->load("Mysql");
        if ($db->getId()) {
            $iRes = $db->update("wei_usr", [
                "name"     => $this->getName(),
                "password" => $this->getPassword(),
                "logo"     => $this->getLogo(),
                "openid"   => $this->getOpenid(),
            ],
                [
                    "id[=]" => $db->getId()
                ]);
        } else {
            $iRes = $db->insert("wei_usr", [
                "name"     => $this->getName(),
                "password" => $this->getPassword(),
                "logo"     => $this->getLogo(),
                "openid"   => $this->getOpenid(),
            ]);
        }
        return $iRes;
    }
}