<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 17:02
 */


return [
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
    "Alidayu"  => function () {
        require_once(ROOT . "/src/ext/alidayu/Alidayu.php");
        $c            = new \TopClient;
        $c->appkey    = "23573406";
        $c->secretKey = "3709c4a712514ce34e4b1bcfe19be422";
        $req          = new \AlibabaAliqinFcSmsNumSendRequest;
        return $req;
    }
];