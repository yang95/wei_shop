<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\Order;

use WEI\Domain\Cart\CartItem;
use WEI\Domain\Common\DomainCommon;
use WEI\Domain\Product\ProductItem;
use WEI\Domain\Product\ProductService;
use WEI\Domain\User\UserItem;
use WEI\Domain\User\UserService;

class OrderService extends DomainCommon implements OrderInterface
{
    public function createOrder(UserItem $user, ProductItem $item)
    {
        // TODO: Implement createOrder() method.
    }

    public function createOrderByCart(UserItem $user, CartItem $item)
    {
        // TODO: Implement createOrderByCart() method.
    }

    public function payOrder()
    {
        #@todo
    }

    public function cancelOrder()
    {
        #@todo
    }

    public function define_cancelOrder()
    {
        #@todo
    }

    /**
     * 获取全部订单
     *
     * @param UserItem $User
     *
     * @return array
     */
    public function getOrder(UserItem $User)
    {
        $user_id = $User->getId();
        $db      = $this->load("Mysql");
        $tmp     = $db->select("wei_order",
            "*",
            [
                "user_id[=]" => $user_id
            ]
        );
        $vData   = [];
        foreach ($tmp as $val) {
            if (!empty($val)) {
                array_push($vData, $this->buildOrder($val));
            }
        }
        return $vData;
    }

    /**
     * 从数据库实例化对象
     *
     * @param $tmp
     *
     * @return OrderItem
     */
    public function buildOrder($tmp)
    {
        /** @var OrderItem $c */
        $c = $this->domain("Order", "OrderItem");
        if (isset($tmp["id"])) {
            $c->setId($tmp["id"]);
        }
        if (isset($tmp["user_id"])) {
            /** @var UserService $u_s */
            $u_s  = $this->domain("User", "UserService");
            $User = $u_s->getUserById($tmp["user_id"]);
            $c->setUser($User);
        }
        if (isset($tmp["product_id"])) {
            /** @var ProductService $p_s */
            $p_s  = $this->domain("Product", "ProductService");
            $User = $p_s->getProductById($tmp["product_id"]);
            $c->setProduct($User);
        }
        if (isset($tmp["address"])) {
            $c->setAddress($tmp["address"]);
        }
        if (isset($tmp["param"])) {
            $c->setParam($tmp["param"]);
        }
        if (isset($tmp["pay"])) {
            $c->setPay($tmp["pay"]);
        }
        if (isset($tmp["wuliu"])) {
            $c->setWuliu($tmp["wuliu"]);
        }
        return $c;
    }
}