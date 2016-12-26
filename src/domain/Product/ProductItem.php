<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 10:19
 */

namespace WEI\Domain\Product;

use WEI\Domain\Common\DomainCommon;

class ProductItem extends DomainCommon
{
    public $id;
    public $name;
    public $price;
    public $from;
    public $credit;
    public $content;
    public $sale;
    public $look;
    public $brand;
    public $size;
    public $product;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * @param mixed $credit
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * @param mixed $sale
     */
    public function setSale($sale)
    {
        $this->sale = $sale;
    }

    /**
     * @return mixed
     */
    public function getLook()
    {
        return $this->look;
    }

    /**
     * @param mixed $look
     */
    public function setLook($look)
    {
        $this->look = $look;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param mixed $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
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
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    public function get($key = null)
    {
        if (empty($key)) {
            return $this->product;
        } else {
            return isset($this->product[$key])
                ? $this->product[$key]
                : 0;
        }
    }

    public function set($key, $value)
    {
        return $this->product[$key] = $value;
    }

    /**
     *保存商品
     *
     * @return mixed
     */
    public function save()
    {
        $db      = $this->load("Mysql");
        $id      = $this->getId();
        $product = json_encode($this->getProduct());
        #$db->debug();
        if ($id) {
            $iRes = $db->update('wei_product', [
                "name"    => $this->getName(),
                "price"   => $this->getPrice(),
                "from"    => $this->getFrom,
                "credit"  => $this->getCredit(),
                "content" => $this->getContent(),
                "sale"    => $this->getSale(),
                "look"    => $this->getLook(),
                "brank"   => $this->getBrand(),
                "size"    => $this->getSize(),
                "product" => $product
            ],
                [
                    "id[=]" => $id
                ]);
        } else {
            $iRes = $db->insert('wei_user',
                [
                    "name"    => $this->getName(),
                    "price"   => $this->getPrice(),
                    "from"    => $this->getFrom,
                    "credit"  => $this->getCredit(),
                    "content" => $this->getContent(),
                    "sale"    => $this->getSale(),
                    "look"    => $this->getLook(),
                    "brank"   => $this->getBrand(),
                    "size"    => $this->getSize(),
                    "product" => $product
                ]
            );
        }
        return $iRes;
    }

}