<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/26
 * Time: 11:03
 */


namespace WEI\Domain\Ad;

use WEI\Domain\Common\DomainCommon;

class AdItem extends DomainCommon
{
    public $id;
    public $name;
    public $picture;
    public $content;
    public $position;
    public $info;

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
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
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
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param mixed $info
     */
    public function setInfo($info)
    {
        $info       = json_encode($info, true);
        $info       = is_array($info) ? $info : [];
        $this->info = $info;
    }

    public function save()
    {
        $db = $this->load("Mysql");
        #$db->debug();
        if ($this->getId()) {
            $iRes = $db->update('wei_ad', [
                "name"     => $this->getName(),
                "picture"  => $this->getPicture(),
                "content"  => $this->getContent(),
                "position" => $this->getPosition(),
                "info"     => $this->getInfo(),
            ],
                [
                    "id[=]" => $this->getId()
                ]);
        } else {
            $iRes = $db->insert('wei_ad', [
                "name"     => $this->getName(),
                "picture"  => $this->getPicture(),
                "content"  => $this->getContent(),
                "position" => $this->getPosition(),
                "info"     => $this->getInfo(),
            ]);
        }
        return $iRes;
    }


}