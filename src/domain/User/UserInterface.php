<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/21
 * Time: 14:11
 */

namespace WEI\Domain\User;


interface UserInterface
{
    /**
     * @param $id
     *
     * @return mixed
     */
    public function getUserById($id);
}