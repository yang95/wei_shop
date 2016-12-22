<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 17:02
 */


return [
    "Log"       => function () {
        $log = new WEI\Lib\Log\Log(ROOT . "/public/log/" . date("Y-m-d") . ".log");
        return $log;
    },
    "Mysql"     => function () {
        $database = new \medoo([
            'database_type' => 'mysql',
            'database_name' => 'yangakw',
            'server'        => 'localhost',
            'username'      => 'root',
            'password'      => 'root',
            'charset'       => 'utf8'
        ]);
        return $database;
    },
    "Alidayu"   => function () {
        require_once(ROOT . "/src/ext/alidayu/Alidayu.php");
        $c            = new \TopClient;
        $c->appkey    = "23573406";
        $c->secretKey = "3709c4a712514ce34e4b1bcfe19be422";
        return $c;
    },
    "phpmailer" => function () {
        $mail = new \PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug   = 0;
        $mail->Debugoutput = 'html';
        $mail->Host        = "smtp.163.com";
        $mail->Port        = 25;
        $mail->SMTPAuth    = true;
        $mail->CharSet     = "utf-8";
        $mail->Username    = "yangakw@163.com";
        $mail->Password    = "admin123";
        $mail->setFrom('yangakw@163.com', 'wei_shop');
        $mail->addReplyTo('yangakw@163.com', 'wei_shop');
        return $mail;
        /*
        $mail->Subject = $subject;
        $mail->AltBody = self::AltBody;
        $mail->msgHTML($body);
        $mail->addAddress($to,$to);
        $mail->send()
        */
    },
    "Qiniu"     => function () {
        $bucket    = "utuotu-v1";
        $accessKey = "16UtFTryGnDJhcFrji1TYVKB-MK_axGzkmu5BVuP";
        $secretKey = "HJKacVbPdmM2m9AOGKsb55DetHMfmmwfRrAToZQK";
        $auth      = new \Qiniu\Auth($accessKey, $secretKey);
        $upToken   = $auth->uploadToken($bucket);
        return $upToken;
    }
];