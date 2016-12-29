<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\Pay;

use WEI\Domain\Common\DomainCommon;
use WEI\Domain\Order\OrderItem;
use WEI\Domain\Order\OrderService;
use WEI\Domain\User\UserCredit;
use WEI\Domain\User\UserItem;

class PayService extends DomainCommon
{
    const  SHOPPING = "积分兑换商品";

    /**
     * 支付成功
     *
     * @param UserItem  $user
     * @param OrderItem $item
     * @param           $money
     *
     * @return int
     */
    public function pay(UserItem $user, OrderItem $item, $money)
    {
        $re = 0;
        if ($user->getId() == $item->getUser()->getId()) {
            /** @var OrderService $o_s */
            $o_s = $this->domain("Order", "OrderService");
            $re  = $this->payOrder($item, $money);
        }
        return $re;
    }

    /**
     * 取消支付
     *
     * @param OrderItem $item
     */
    public function cancelPay(OrderItem $item)
    {
        if ($item->getPay() > 0) {
            $item->setPay(0);
        }
    }

    /**
     * @param UserItem  $user
     * @param OrderItem $item
     *
     * @return bool|int
     */
    public function payByCredit(UserItem $user, OrderItem $item)
    {
        /** @var UserCredit $u_credit */
        $u_credit = $user->getCredit();
        $credit   = $u_credit->getCredit();
        $credit_p = $item->get("credit");
        if ($credit_p < 1) {
            return -3;#商品不支持积分兑换
        }
        if ($credit_p > $credit) {
            return -2;#用户积分不够
        }
        $credit = $credit - $credit_p;
        $money  = $item->get("money");
        $this->pay($user, $item, $money);
        return $u_credit->handle(-1 * $credit_p, self::SHOPPING);
    }

    /**
     * @param OrderItem $o_i
     * @param           $money
     *
     * @return mixed
     */
    private function payOrder(OrderItem $o_i, $money)
    {
        $o_i->setPay($money);
        return $o_i->save();
    }
}