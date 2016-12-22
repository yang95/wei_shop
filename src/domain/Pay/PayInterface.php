<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/21
 * Time: 14:02
 */

namespace WEI\Domain\Pay;


use WEI\Domain\Order\OrderItem;
use WEI\Domain\Product\ProductItem;
use WEI\Domain\User\UserItem;

interface PayInterface
{
    /**
     * @param UserItem    $user
     * @param ProductItem $item
     *
     * @return mixed
     */
    public function pay(UserItem $user, OrderItem $item);

    /**
     * @param UserItem  $userItem
     * @param OrderItem $item
     *
     * @return mixed
     */
    public function cancelPay(UserItem $userItem,OrderItem $item);
}