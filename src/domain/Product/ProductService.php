<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\Product;

use WEI\Domain\Common\DomainCommon;
use WEI\Domain\User\UserItem;
use WEI\Lib\Db\Db;

class ProductService extends DomainCommon implements ProductInterface
{
    public $User;

    /**
     * 权限判断  返回小于0权限不够
     *
     * @param UserItem|null $User
     *
     * @return int
     */
    public function initialize(UserItem $User = null)
    {
        if (empty($this->User) && empty($User)) {
            return -1;
        }
        if (empty($this->User)) {
            $this->User = $User;
        }
        $User = $this->User;
        if ($User->getRank() < 10) {
            return -2;
        }
        return 1;
    }


    /**
     * 根据分类获取产品
     *
     * @param ProductCate $father
     *
     * @return array
     */
    public function getProductByCate(ProductCate $father)
    {
        $iData = $this->getProductCateByFather($father);
        $vData = [];
        foreach ($iData as $val) {
            if ($val instanceof ProductCate) {
                array_merge($vData, $val->getProduct());
            }
        }
        return $vData;
    }

    /**
     *获取一个产品详情
     *
     * @param $id
     *
     * @return mixed
     */
    public function getProductById($id)
    {
        $db   = $this->load("Mysql");
        $data = $db->get("wei_product", "*", ["id[=]" => $id]);
        return $this->buildProduct($data);
    }

    /**
     * 自定义筛选产品
     *
     * @param $cond
     *
     * @return array
     */
    public function getProductByCond($cond)
    {
        /** @var Db $db */
        $db = $this->load("Mysql");
        $data  = $db->select("wei_product", "*", $cond);
        $vData = [];
        if (!empty($data)) {
            foreach ($data as $v) {
                if (is_array($v) && isset($v["id"])) {
                    array_push($vData, $this->buildProduct($v));
                }
            }
        }
        return $vData;
    }

    /**
     * 删除商品
     *
     * @param $id
     *
     * @return mixed
     */
    public function rmProduct($id)
    {
        $db = $this->load("Mysql");
        return $db->delete("wei_product", ["id[=]" => $id]);
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function getProductCateById($id)
    {
        $db   = $this->load("Mysql");
        $data = $db->get("wei_product_cate", "*", ["id[=]" => $id]);
        return $this->buildCate($data);
    }

    /**
     * son cate
     *
     * @param ProductCate $father
     *
     * @return array|null
     */
    public function getProductCateByFather(ProductCate $father)
    {
        $db   = $this->load("Mysql");
        $data = $db->select("wei_product_cate", "*", ["father[=]" => $father->getId()]);
        if (empty($data)) {
            return null;
        }
        $vData = [];
        foreach ($data as $v) {
            if (is_array($v) && isset($v["id"])) {
                $son = $this->buildCate($v);
                array_push($vData, $son);
                if ($son instanceof ProductCate) {
                    $iData = $this->getProductCateByFather($son);
                    if (is_array($iData)) {
                        $vData = array_merge($vData, $iData);
                    }
                }
            }
        }
        return $vData;
    }

    /**
     *
     * produce 在哪个分类下
     *
     * @param ProductItem $item
     *
     * @return array
     */
    public function getCateByProduct(ProductItem $item)
    {
        $id     = $item->getId();
        $vLists = [];
        $father = $this->getProductCateById(0);
        $list   = $this->getProductCateByFather($father);
        foreach ($list as $li) {
            $data = $li->getCate();
            if (in_array($data, $id)) {
                array_push($vLists, $li);
            }
        }
        return $vLists;
    }

    /**
     * 删除商品分类
     *
     * @param $id
     *
     * @return mixed
     */
    public function rmProductCategory($id)
    {
        $db = $this->load("Mysql");
        return $db->delete("wei_product", ["id[=]" => $id]);
    }


    /**
     * 保存商品
     *
     * @param $tmp
     *
     * @return int
     */
    public function saveProduct($tmp)
    {
        $vData = 0;
        if ($this->initialize() < 0) {
            goto END;
        }
        $p_i   = $this->buildProduct($tmp);
        $vData = $p_i->save();
        END:
        return $vData;
    }

    /**
     * 保存分类
     *
     * @param $tmp
     *
     * @return int
     */
    public function saveCate($tmp)
    {
        $vData = 0;
        if ($this->initialize() < 0) {
            goto END;
        }
        $p_i   = $this->buildCate($tmp);
        $vData = $p_i->save();
        END:
        return $vData;
    }

    #################适配器
    public function buildCate($tmp)
    {
        $c = $this->domain("Product", "ProductCate");
        if (isset($tmp["id"])) {
            $c->setId($tmp["id"]);
        }
        if (isset($tmp["name"])) {
            $c->setName($tmp["name"]);
        }
        if (isset($tmp["cate"])) {
            $c->setCate($tmp["cate"]);
        }
        if (isset($tmp["father"])) {
            $c->setFather($tmp["father"]);
        }
        return $c;
    }

    /**
     * @param $tmp
     *
     * @return null|ProductItem
     */
    public function buildProduct($tmp)
    {
        /** @var ProductItem $c */
        $c = $this->domain("Product", "ProductItem");
        if (isset($tmp["id"])) {
            $c->setId($tmp["id"]);
        }
        if (isset($tmp["name"])) {
            $c->setName($tmp["name"]);
        }
        if (isset($tmp["from"])) {
            $c->setFrom($tmp["from"]);
        }
        if (isset($tmp["price"])) {
            $c->setPrice($tmp["price"]);
        }
        if (isset($tmp["credit"])) {
            $c->setCredit($tmp["credit"]);
        }
        if (isset($tmp["content"])) {
            $c->setContent($tmp["content"]);
        }
        if (isset($tmp["sale"])) {
            $c->setSale($tmp["sale"]);
        }
        if (isset($tmp["look"])) {
            $c->setLook($tmp["look"]);
        }
        if (isset($tmp["brank"])) {
            $c->setBrand($tmp["brank"]);
        }
        if (isset($tmp["size"])) {
            $c->setSize($tmp["size"]);
        }
        if (empty($tmp)) {
            return null;
        }
        foreach ($tmp as $k => $v) {
            $c->set($k, $v);
        }
        return $c;
    }
}