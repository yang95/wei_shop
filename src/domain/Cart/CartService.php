<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\Cart;

use WEI\Domain\Common\DomainCommon;
use WEI\Domain\Product\ProductService;
use WEI\Domain\User\UserItem;
use WEI\Domain\User\UserService;

class CartService extends DomainCommon
{
    public function createCart()
    {
        #@todo
    }

    public function rmCart()
    {
        #@todo
    }

    public function rmCartAll()
    {
        #@todo
    }

    /**
     * 获取全部
     *
     * @param UserItem $User
     *
     * @return array
     */
    public function getOrder(UserItem $User)
    {
        $user_id = $User->getId();
        $db      = $this->load("Mysql");
        $tmp     = $db->select("wei_cart",
            "*",
            [
                "user_id[=]" => $user_id
            ]
        );
        $vData   = [];
        foreach ($tmp as $val) {
            if (!empty($val)) {
                array_push($vData, $this->buildCart($val));
            }
        }
        return $vData;
    }

    /**
     * 从数据库创建对象
     *
     * @param $tmp
     *
     * @return CartItem
     */
    public function buildCart($tmp)
    {
        /** @var CartItem $c_i */
        $c_i = $this->domain("Cart", "CartItem");
        if (isset($tmp["id"])) {
            $c_i->setId($tmp["id"]);
        }
        if (isset($tmp["user_id"])) {
            /** @var UserService $u_s */
            $u_s  = $this->domain("User", "UserService");
            $User = $u_s->getUserById($tmp["user_id"]);
            $c_i->setUser($User);
        }
        if (isset($tmp["product_id"])) {
            /** @var ProductService $p_s */
            $p_s  = $this->domain("Product", "ProductService");
            $User = $p_s->getProductById($tmp["product_id"]);
            $c_i->setProduct($User);
        }
        if (isset($tmp["address"])) {
            $c_i->setAddress($tmp["address"]);
        }
        if (isset($tmp["param"])) {
            $c_i->setParam($tmp["param"]);
        }
        return $c_i;
    }
}