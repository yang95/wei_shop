<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/21
 * Time: 14:07
 */

namespace WEI\Domain\Order;


use WEI\Domain\Cart\CartItem;
use WEI\Domain\Product\ProductItem;
use WEI\Domain\User\UserItem;

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