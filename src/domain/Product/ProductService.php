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
        $db    = $this->load("Mysql");
        $data  = $db->select("wei_product", "*", $cond);
        $vData = [];
        foreach ($data as $v) {
            if (is_array($v) && isset($v["id"])) {
                array_push($vData, $this->buildProduct($v));
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

    public function getProductCateByFather(ProductCate $father)
    {
        $db   = $this->load("Mysql");
        $data = $db->select("wei_product_cate", "*", ["father[=]" => $father->getFather()]);
        if (empty($data)) {
            return 0;
        }
        $vData[] = $father;
        foreach ($data as $v) {
            if (is_array($v) && isset($v["id"])) {
                $son = $this->buildCate($v);
                array_push($vData, $son);
                $iData = $this->getProductCateByFather($son);
                if (is_array($iData)) {
                    array_merge($vData, $iData);
                }
            }
        }
        return $vData;
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

    public function buildProduct($tmp)
    {
        $c = $this->domain("Product", "ProductItem");
        foreach ($tmp as $k => $v) {
            $c->set($k, $v);
        }
        return $c;
    }
}