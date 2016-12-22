<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/22
 * Time: 13:51
 */
namespace WEI\Console\Test;

use WEI\Console\CliCommon;

class Test extends CliCommon
{
    public function demo(){
        $user_service = $this->domain("User","UserService");
        $user_service->getUserById(1);
        echo "hello world";
    }
}