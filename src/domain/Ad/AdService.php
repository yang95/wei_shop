<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/26
 * Time: 11:03
 */
namespace WEI\Domain\Ad;

use WEI\Domain\Common\DomainCommon;
use WEI\Lib\Db\Db;

class AdService extends DomainCommon
{
    /**
     * @param $arr
     *
     * @return array
     */
    public function getAdList($arr)
    {
        $vData = [];
        foreach ($arr as $v) {
            $vData[$v] = $this->getAdByPosition($v);
        }
        return $vData;
    }

    /**
     * 通过位置获取ad
     *
     * @param $position
     *
     * @return AdItem
     */
    public function getAdByPosition($position)
    {
        $db = $this->load("Mysql");
        $d  = $db->get("wei_ad", "*", ["position[=]" => $position]);
        return $this->buildAd($d);
    }

    /**
     * 获取ad list
     * @param $array
     *
     * @return array
     */
    public function getAd($array){
        /** @var Db $db */
        $db = $this->load("Mysql");
        #$db->debug();
        $d  = $db->select("wei_ad", "*",$array );
        if(empty($d)){
            return;
        }
        $vData = [];
        foreach( $d as $value){
            if(  isset($value["id"]) ){
                $tmp = $this->buildAd($value);
                array_push($vData,$tmp);
            }
        }
        return $vData;
    }

    /**
     * @param $tmp
     *
     * @return AdItem
     */
    public function buildAd($tmp)
    {
        /** @var AdItem $c_i */
        $c_i = $this->domain("Ad", "AdItem");
        if (isset($tmp["id"])) {
            $c_i->setId($tmp["id"]);
        }
        if (isset($tmp["name"])) {
            $c_i->setName($tmp["name"]);
        }
        if (isset($tmp["picture"])) {
            $c_i->setPicture($tmp["picture"]);
        }
        if (isset($tmp["content"])) {
            $c_i->setContent($tmp["content"]);
        }
        if (isset($tmp["position"])) {
            $c_i->setPosition($tmp["position"]);
        }
        if (isset($tmp["info"])) {
            $c_i->setInfo($tmp["info"]);
        }
        return $c_i;
    }
}