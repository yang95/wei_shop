<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/21
 * Time: 14:09
 */

namespace WEI\Domain\Cart;


use WEI\Domain\Product\ProductItem;
use WEI\Domain\User\UserItem;

interface CartInterface
{
    public function createCart(UserItem $User, ProductItem $item);
}