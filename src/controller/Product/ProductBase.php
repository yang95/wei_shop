<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/26
 * Time: 15:45
 */

namespace WEI\Controller\Product;


use WEI\Controller\RestCommon;
use WEI\Domain\Product\ProductCate;
use WEI\Domain\Product\ProductService;
use WEI\Domain\User\UserItem;
use WEI\Domain\User\UserService;
use WEI\Lib\Error\Error;

class ProductBase extends RestCommon
{
    /**
     * 获取产品
     *
     */
    public function productAction()
    {
        /** @var ProductService $p_s */
        $p_s  = $this->domain("Product", "ProductService");
        $cond = [];
        END:
        $rData = $p_s->getProductByCond($cond);
        $this->finish(Error::ERR_NONE, $rData);
    }

    /**
     * 获取子分类
     *
     * @request cid
     */
    public function catesonAction()
    {
        $req   = $this->REQ->request();
        $rData = false;
        $id    = isset($req["cid"]) ? $req["cid"] : 0;
        $id    = intval($id);
        /** @var ProductService $p_s */
        $p_s    = $this->domain("Product", "ProductService");
        $father = $p_s->getProductCateById($id);
        if ($father instanceof ProductCate) {
            $rData = $p_s->getProductCateByFather($father);
        }
        $this->finish(Error::ERR_NONE, $rData);
    }

    /**
     * 获取商品分类
     *
     * @request pid
     */
    public function getcatebyproductAction()
    {
        $req   = $this->REQ->request();
        $rData = false;
        $id    = isset($req["pid"]) ? $req["pid"] : 0;
        /** @var ProductService $p_s */
        $p_s   = $this->domain("Product", "ProductService");
        $p_i   = $p_s->getProductById($id);
        $rData = $p_s->getCateByProduct($p_i);
        $this->finish(Error::ERR_NONE, $rData);
    }


    /**
     * 保存商品
     *
     * @request id   非必需;
     * @request name;
     * @request price;
     * @request from;
     * @request credit;
     * @request content;
     * @request sale;
     * @request look;
     * @request brand;
     * @request size;
     * @request product;
     */
    public function saveproductAction()
    {
        /** @var UserItem $u_s */
        $u_i = $this->getUser();
        /** @var ProductService $p_s */
        $p_s = $this->domain("Product", "ProductService");
        $p_s->initialize($u_i);
        $iData = $this->REQ->request();
        $rData = $p_s->saveProduct($iData);
        $this->finish(Error::ERR_NONE, $rData);
    }

    /**
     * 保存分类
     *
     * @request  id;
     * @request  name;
     * @request  father;
     * @request  cate;
     */
    public function savecateAction()
    {
        /** @var UserItem $u_s */
        $u_i = $this->getUser();
        /** @var ProductService $p_s */
        $p_s = $this->domain("Product", "ProductService");
        $p_s->initialize($u_i);
        $iData = $this->REQ->request();
        $rData = $p_s->saveCate($iData);
        $this->finish(Error::ERR_NONE, $rData);
    }

}