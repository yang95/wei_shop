<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/21
 * Time: 14:09
 */

namespace WEI\Controller\Domain\Cart;


use WEI\Controller\Domain\Product\ProductItem;
use WEI\Controller\Domain\User\UserItem;

interface CartInterface
{
    public function createCart(UserItem $User, ProductItem $item);
}