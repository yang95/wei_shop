<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Controller\Domain\Pay;

use WEI\Controller\Domain\Common\DomainCommon;
use WEI\Controller\Domain\Order\OrderItem;
use WEI\Controller\Domain\User\UserItem;

class PayService extends DomainCommon implements PayInterface
{
    public function pay(UserItem $user, OrderItem $item)
    {
        // TODO: Implement pay() method.
    }

    public function cancelPay(UserItem $userItem, OrderItem $item)
    {
        // TODO: Implement cancelPay() method.
    }
}