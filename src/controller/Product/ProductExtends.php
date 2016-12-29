<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/26
 * Time: 15:45
 */

namespace WEI\Controller\Product;


use WEI\Controller\RestCommon;
use WEI\Domain\Cart\CartItem;
use WEI\Domain\Cart\CartService;
use WEI\Domain\Order\OrderItem;
use WEI\Domain\Order\OrderService;
use WEI\Domain\Pay\PayService;
use WEI\Domain\Product\ProductCate;
use WEI\Domain\Product\ProductItem;
use WEI\Domain\Product\ProductService;
use WEI\Domain\User\UserItem;
use WEI\Domain\User\UserService;
use WEI\Lib\Error\Error;

class ProductExtends extends RestCommon
{
    /**
     * 分类下的商品
     *
     * @request cid
     */
    public function productByCateAction()
    {
        $req   = $this->REQ->request();
        $rData = false;
        $id    = isset($req["cid"]) ? $req["cid"] : 0;
        $id    = intval($id);
        /** @var ProductService $p_s */
        $p_s   = $this->domain("Product", "ProductService");
        $c_i   = $p_s->getProductCateById($id);
        $vData = [];
        if ($c_i instanceof ProductCate) {
            $vData = array_merge($vData, $c_i->getProduct());
        }
        $this->finish(Error::ERR_NONE, $vData);
    }

    /**
     *添加到购物车
     *
     * @request pid
     * @request param
     */
    public function addcartAction()
    {
        $user  = $this->getUser();
        $req   = $this->REQ->request();
        $rData = false;
        $pid   = isset($req["pid"]) ? $req["pid"] : 0;
        $param = isset($req["param"]) ? $req["param"] : 0;
        /** @var ProductService $p_s */
        $p_s = $this->domain("Product", "ProductService");
        /** @var CartService $c_s */
        $c_s = $this->domain("Cart", "CartService");
        $p_i = $p_s->getProductById($pid);
        if (!($p_i instanceof ProductItem)) {
            goto ERR_VALUE;
        }
        $return = $c_s->createCart($user, $p_i, $param);
        return $this->finish(Error::ERR_NONE, $return);
        ERR_VALUE:
        return $this->finish(Error::ERR_VALUE, "");
    }

    /**
     *删除购物车
     *
     * @request cid
     */
    public function rmcartAction()
    {
        $user  = $this->getUser();
        $req   = $this->REQ->request();
        $rData = false;
        $cid   = isset($req["cid"]) ? $req["cid"] : -1;
        /** @var CartService $c_s */
        $c_s = $this->domain("Cart", "CartService");
        if ($cid == -1) {
            $return = $c_s->rmCartAll($user);
        } else {
            $cart = $c_s->getCartById($user, $cid);
            if (!($cart instanceof CartItem)) {
                goto ERR_VALUE;
            }
            $return = $cart->rm();
        }
        return $this->finish(Error::ERR_NONE, $return);
        ERR_VALUE:
        return $this->finish(Error::ERR_VALUE, "");
    }

    /**
     * 生成订单
     *
     * @request pid
     */
    public function addorderAction()
    {
        $user  = $this->getUser();
        $req   = $this->REQ->request();
        $pid   = isset($req["pid"]) ? $req["pid"] : 0;
        $param = isset($req["param"]) ? $req["param"] : 0;
        /** @var ProductService $p_s */
        $p_s = $this->domain("Product", "ProductService");
        /** @var OrderService $o_s */
        $o_s = $this->domain("Order", "OrderService");
        $p_i = $p_s->getProductById($pid);
        if (!($p_i instanceof ProductItem)) {
            goto ERR_VALUE;
        }
        $oid = $o_s->createOrder($user, $p_i, $param);
        return $this->finish(Error::ERR_NONE, ["order" => $oid]);
        ERR_VALUE:
        return $this->finish(Error::ERR_VALUE, "");
    }

    /**
     * 购物车生成订单
     *
     * @request cid
     */
    public function addorderbycartAction()
    {
        $user  = $this->getUser();
        $req   = $this->REQ->request();
        $rData = false;
        $cid   = isset($req["cid"]) ? $req["cid"] : 0;
        $param = isset($req["param"]) ? $req["param"] : 0;
        /** @var CartService $c_s */
        $c_s = $this->domain("Cart", "CartService");
        /** @var OrderService $o_s */
        $o_s = $this->domain("Order", "OrderService");
        $c_i = $c_s->getCartById($user, $cid);
        if (!($c_i instanceof CartItem)) {
            goto ERR_VALUE;
        }
        $oid = $o_s->createOrderByCart($user, $c_i, $param);
        return $this->finish(Error::ERR_NONE, ["order" => $oid]);
        ERR_VALUE:
        return $this->finish(Error::ERR_VALUE, "");
    }

    /**
     *支付结果
     *
     * @request oid
     *          money
     */
    public function payorderAction()
    {
        $user  = $this->getUser();
        $req   = $this->REQ->request();
        $rData = false;
        $oid   = isset($req["oid"]) ? $req["oid"] : 0;
        $money = isset($req["money"]) ? $req["money"] : 0;
        /** @var OrderService $o_s */
        $o_s = $this->domain("Order", "OrderService");
        /** @var PayService $pay_service */
        $pay_service = $this->domain("Pay", "PayService");
        $order       = $o_s->getOrderById($user, $oid);
        if (!($order instanceof OrderItem)) {
            goto ERR_VALUE;
        }
        $pay_result = $pay_service->pay($user, $order, $money);
        return $this->finish(Error::ERR_NONE, ["result" => $pay_result]);
        ERR_VALUE:
        return $this->finish(Error::ERR_VALUE, "");
    }

    /**
     *设置物流
     *
     * @request oid
     *          wuliu
     */
    public function setwuliuAction()
    {
        $user  = $this->getUser();
        $req   = $this->REQ->request();
        $rData = false;
        $oid   = isset($req["oid"]) ? $req["oid"] : 0;
        $wuliu = isset($req["wuliu"]) ? $req["wuliu"] : 0;
        if (empty($wuliu)) {
            goto ERR_VALUE;
        }
        /** @var OrderService $o_s */
        $o_s   = $this->domain("Order", "OrderService");
        $order = $o_s->getOrderById($user, $oid);
        if (!($order instanceof OrderItem)) {
            goto ERR_VALUE;
        }
        $order->setWuliu($wuliu);
        $result = $order->save();
        return $this->finish(Error::ERR_NONE, ["result" => $result]);
        ERR_VALUE:
        return $this->finish(Error::ERR_VALUE, "");
    }
}