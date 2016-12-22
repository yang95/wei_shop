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
use WEI\Domain\User\UserItem;

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
}