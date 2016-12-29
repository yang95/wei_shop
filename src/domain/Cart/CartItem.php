<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\Cart;

use WEI\Domain\Common\DomainCommon;

class CartItem extends DomainCommon
{
    public $id;
    public $address;
    public $user;
    public $product;
    public $param;

    public function set($key, $value)
    {
        $data        = $this->getParam();
        $data[$key]  = $value;
        $this->param = $data;
    }

    public function get($key)
    {
        $data = $this->getParam();
        return isset($data[$key]) ? $data[$key] : '';
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return is_array($this->param) ? $this->param : [];
    }

    /**
     * @param mixed $param
     */
    public function setParam($param)
    {
        $this->param = json_decode($param, true);
    }

    /**
     * @return mixed
     */
    public function rm()
    {
        $db = $this->load("Mysql");
        return $db->delete('wei_cart',
            [
                "id[=]" => $this->getId()
            ]
        );
    }

    /*
     *
     * 保存购物车
     */
    public function save()
    {
        $db = $this->load("Mysql");
        #$db->debug();
        if ($this->getId()) {
            $iRes = $db->update('wei_cart', [
                "user_id"    => $this->getUser()->getId(),
                "product_id" => $this->getProduct()->getId(),
                "address"    => $this->getAddress(),
                "param"      => $this->getParam()
            ],
                [
                    "id[=]" => $this->getId()
                ]);
        } else {
            $iRes = $db->insert('wei_cart', [
                "user_id"    => $this->getUser()->getId(),
                "product_id" => $this->getProduct()->getId(),
                "address"    => $this->getAddress(),
                "param"      => $this->getParam()
            ]);
        }
        return $iRes;
    }
}