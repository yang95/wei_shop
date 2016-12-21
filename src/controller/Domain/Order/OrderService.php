<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Controller\Domain\Order;

use WEI\Controller\Domain\Cart\CartItem;
use WEI\Controller\Domain\Common\DomainCommon;
use WEI\Controller\Domain\Product\ProductItem;
use WEI\Controller\Domain\User\UserItem;

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