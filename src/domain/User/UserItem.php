<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\User;

use WEI\Domain\Common\DomainCommon;

class UserItem extends DomainCommon
{
    public $id;
    public $openid;
    public $name;
    public $password;
    public $Rank;
    public $phone;
    public $email;
    public $valid_phone;
    public $valid_email;

    /**
     * 获取用户的积分
     *
     * @return UserCredit
     */
    public function getCredit()
    {
        $Credit = new UserCredit($this);
        return $Credit;
    }

    /**
     * 返回OrderService 对象
     *
     * @return mixed
     */
    public function getOrder()
    {
        $o_s = $this->domain("Order", "OrderService");
        return $o_s;
    }

    /**
     * 返回购物车对象
     *
     * @return mixed
     */
    public function getCart()
    {
        $o_s = $this->domain("Cart", "CartService");
        return $o_s;
    }

################
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
    public function getRank()
    {
        $rank = empty($this->Rank) ? 0 : $this->Rank;
        return $rank;
    }

    /**
     * @param mixed $Rank
     */
    public function setRank($Rank)
    {
        $this->Rank = $Rank;
    }

    /**
     * @return mixed
     */
    public function getOpenid()
    {
        return empty($this->openid) ? '' : $this->openid;
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
     * @return mixed
     */
    public function getPhone()
    {
        return empty($this->phone) ? '' : $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return empty($this->email) ? '' : $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getValidPhone()
    {
        $valid = empty($this->valid_phone) ? 0 : $this->valid_phone;
        return $valid;
    }

    /**
     * @param mixed $valid_phone
     */
    public function setValidPhone($valid_phone)
    {
        $this->valid_phone = $valid_phone;
    }

    /**
     * @return mixed
     */
    public function getValidEmail()
    {
        $valid = empty($this->valid_email) ? 0 : $this->valid_email;
        return $valid;
    }

    /**
     * @param mixed $valid_email
     */
    public function setValidEmail($valid_email)
    {
        $this->valid_email = $valid_email;
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
     *保存用户
     *
     * @return mixed
     */
    public function save()
    {
        $db = $this->load("Mysql");
        #$db->debug();
        if ($this->getId()) {
            $iRes = $db->update('wei_user', [
                "name"        => $this->getName(),
                "password"    => $this->getPassword(),
                "rank"        => $this->getRank(),
                "openid"      => $this->getOpenid(),
                "phone"       => $this->getPhone(),
                "email"       => $this->getEmail(),
                "valid_phone" => $this->getValidPhone(),
                "valid_email" => $this->getValidEmail(),
            ],
                [
                    "id[=]" => $this->getId()
                ]);
        } else {
            $iRes = $db->insert('wei_user', [
                "name"        => $this->getName(),
                "password"    => $this->getPassword(),
                "rank"        => $this->getRank(),
                "openid"      => $this->getOpenid(),
                "phone"       => $this->getPhone(),
                "email"       => $this->getEmail(),
                "valid_phone" => $this->getValidPhone(),
                "valid_email" => $this->getValidEmail(),
            ]);
        }
        return $iRes;
    }
}