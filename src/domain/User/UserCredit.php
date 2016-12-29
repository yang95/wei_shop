<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/25
 * Time: 15:00
 */

namespace WEI\Domain\User;


use WEI\Domain\Common\DomainCommon;

class UserCredit extends DomainCommon
{
    /** @var  UserItem $User */
    public $User;
    public $change;
    public $crdit;
    public $log;

    /**
     * UserCredit constructor.
     *
     * @param $User
     */
    public function __construct($User)
    {
        $this->User = $User;
    }

    /**
     * @return int
     */
    public function getCredit()
    {
        $db    = $this->load("Mysql");
        $iData = $db->get("wei_user_credit", "*", [
            "user_id",
            $this->User->getId(),
            "ORDER" => [
                "id" => "desc"
            ]
        ]);
        if (isset($iData["credit"])) {
            $iData = $iData["credit"];
        } else {
            $iData = 0;
        }
        return $iData;
    }

    /**
     * @param $cond
     *
     * @return mixed
     */
    public function getCreditList($cond)
    {
        $db    = $this->load("Mysql");
        $iData = $db->select("wei_user_credit", "*", [
            "user_id",
            $this->User->getId(),
            $cond
        ]);
        return $iData;
    }

    /**
     * 日志操作
     *
     * @param $change
     * @param $log
     *
     * @return bool
     */
    public function handle($change, $log)
    {
        $bData  = $this->getCredit();
        $credit = isset($credit) ? $credit : 0;
        $log    = isset($log) ? $log : '';
        $credit = intval($change + $credit);
        if ($credit < 0) {
            return false;
        } else {
            $db    = $this->load("Mysql");
            $iData = $db->update("wei_user_credit", "*", [
                "change" => $change,
                "credit" => $credit,
                "log"    => $log
            ]);
            return $iData;
        }
    }
}