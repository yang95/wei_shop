<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/21
 * Time: 14:07
 */

namespace WEI\Controller\Domain\Order;


use WEI\Controller\Domain\Cart\CartItem;
use WEI\Controller\Domain\Product\ProductItem;
use WEI\Controller\Domain\User\UserItem;

interface OrderInterface
{
    /**
     * @param UserItem    $user
     * @param ProductItem $item
     *
     * @return mixed
     */
    public function createOrder(UserItem $user, ProductItem $item);

    /**
     * @param UserItem $user
     * @param CartItem $item
     *
     * @return mixed
     */
    public function createOrderByCart(UserItem $user, CartItem $item);
}