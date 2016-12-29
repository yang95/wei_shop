<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\Cart;

use WEI\Domain\Common\DomainCommon;
use WEI\Domain\Product\ProductItem;
use WEI\Domain\Product\ProductService;
use WEI\Domain\User\UserItem;
use WEI\Domain\User\UserService;

class CartService extends DomainCommon
{
    /**
     * 创建 购物车
     *
     * @param UserItem    $user
     * @param ProductItem $item
     * @param             $param
     *
     * @return mixed
     */
    public function createCart(UserItem $user, ProductItem $item, $param)
    {
        $data               = is_array($param) ? $param : [];
        $data["user_id"]    = $user->getId();
        $data["product_id"] = $item->getId();
        $c_i                = $this->buildCart($user, $data);
        return $c_i->save();
    }

    /**
     * 清空购物车
     *
     * @param UserItem $User
     *
     * @return int
     */
    public function rmCartAll(UserItem $User)
    {
        $iData = $this->getCart($User);
        $i     = 0;
        if (is_array($iData)) {
            /** @var CartItem $val */
            foreach ($iData as $val) {
                $val->rm();
                $i++;
            }
        }
        return $i;
    }

    /**
     * 获取全部购物车
     *
     * @param UserItem $User
     *
     * @return array
     */
    public function getCart(UserItem $User)
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
                array_push($vData, $this->buildCart($User, $val));
            }
        }
        return $vData;
    }

    /**
     * @param UserItem $user
     * @param          $id
     *
     * @return null|CartItem
     */
    public function getCartById(UserItem $user, $id)
    {
        $db  = $this->load("Mysql");
        $tmp = $db->get("wei_cart",
            "*",
            [
                "id[=]" => $id
            ]
        );
        if (empty($tmp)) {
            return null;
        }
        return $this->buildCart($user, $tmp);
    }

    /**
     * 从数据库创建对象
     *
     * @param UserItem $user
     * @param          $tmp
     *
     * @return CartItem
     */
    public function buildCart(UserItem $user, $tmp)
    {
        /** @var CartItem $c_i */
        $c_i = $this->domain("Cart", "CartItem");
        $c_i->setUser($user);
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