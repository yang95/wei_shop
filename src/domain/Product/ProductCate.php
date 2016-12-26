<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/25
 * Time: 19:31
 */

namespace WEI\Domain\Product;


use WEI\Domain\Common\DomainCommon;
use WEI\Domain\User\UserService;

class ProductCate extends DomainCommon
{
    public $id;
    public $name;
    public $father;
    public $cate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFather()
    {
        return $this->father;
    }

    /**
     * @param mixed $father
     */
    public function setFather($father)
    {
        $this->father = $father;
    }

    /**
     * @return mixed
     */
    public function getCate()
    {
        return $this->cate;
    }

    /**
     * @param mixed $cate
     */
    public function setCate($cate)
    {
        $cate = json_decode($cate, true);
        if (is_array($cate)) {
            $cate = [];
        }
        $this->cate = $cate;
    }

    /**
     * 获取分类下的所有产品
     *
     * @return array
     */
    public function getProduct()
    {
        $vData = [];
        /** @var ProductService $ser */
        $ser = $this->domain("Product", "ProductService");
        foreach ($this->cate as $product_id) {
            #@todo 慢sql优化 使用 in
            $product = $ser->getProductById($product_id);
            if (!empty($product)) {
                array_push($vData, $product);
            }
        }
        return $vData;
    }

    /**
     * 增加商品到分类
     *
     * @param ProductItem $product
     *
     * @return int
     */
    public function addProduct(ProductItem $product)
    {
        $product_id = $product->getId();
        if (!in_array($this->cate, $product_id)) {
            array_push($this->cate, $product_id);
        }
        return 0;
    }

    /**
     * 保存分类
     *
     * @return mixed
     */
    public function save()
    {
        $db   = $this->load("Mysql");
        $cate = $this->getCate();
        $cate = json_encode($cate);
        #$db->debug();
        if ($this->getId()) {
            $iRes = $db->update('wei_product_cate', [
                "name"   => $this->getName(),
                "father" => $this->getFather(),
                "cate"   => $cate,
            ],
                [
                    "id[=]" => $this->getId()
                ]);
        } else {
            $iRes = $db->insert('wei_product_cate', [
                "name"   => $this->getName(),
                "father" => $this->getFather(),
                "cate"   => $cate,
            ]);
        }
        return $iRes;
    }

}