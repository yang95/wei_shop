<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:25
 */

namespace WEI\Controller\Home;


use WEI\Controller\RestCommon;
use WEI\Lib\Error\Error;

class Test extends RestCommon
{
    /**
     * 测试输出中文
     *
     */
    public function runAction()
    {
        $iData = "中文";
        $this->finish(Error::ERR_NONE, $iData);
    }

    /**
     * 测试curl
     */
    public function idoAction()
    {
        $d     = $this->load("Crawler");
        $url   = "http://www.yangakw.cn";
        $sCB   = function ($param) {
            return $param;
        };
        $iData = $d->doOneTask($url, $sCB);
        $this->finish(Error::ERR_NONE, $iData);
    }

    /**
     *测试加密
     */
    public function testAction()
    {
        $crypt    = $this->load("Crypt");
        $password = $crypt->password(45646456456456);
        $this->finish(Error::ERR_NONE, $password);
    }

    /**
     * 测试发送短信
     */
    public function dayuAction()
    {
        $client = $this->load("Alidayu");
        $req    = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("竹海");
        $req->setSmsParam("{\"name\":\"刘阳\"}");
        $req->setRecNum("13665420619");
        $req->setSmsTemplateCode("SMS_34670287");
        $resp = $client->execute($req);
        $this->finish(Error::ERR_NONE, $resp);
    }

    /**
     * 测试发送邮件
     */
    public function imailAction(){
        $mail=$this->load("phpmailer");
        $mail->Subject = "demo";
        $to = "yangakw@qq.com";
        $mail->AltBody = "选择合适邮箱查看工具";
        $mail->msgHTML("woshi 测试邮件");
        $mail->addAddress($to,$to);
        $resp = $mail->send();
        $this->finish(Error::ERR_NONE, $resp);
    }
}