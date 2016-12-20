<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 12:33
 */

namespace WEI\Lib\Crypt;


class Crypt
{
    const PASSWORD_SOLD = "Sd2:sc))";
    const SOLD          = "Sd2:sc))";

    public function password($s)
    {
        return md5($s . self::PASSWORD_SOLD);
    }

    public function encode($s)
    {
        return base64_encode($s);
    }

    public function decode($s)
    {
        return base64_decode($s);
    }
}