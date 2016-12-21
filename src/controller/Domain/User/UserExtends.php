<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 17:19
 */

namespace WEI\Controller\Domain\User;


use WEI\Controller\Domain\Common\DomainCommon;

class UserExtends extends DomainCommon
{
    /** @var  UserItem $User */
    public $User;
    public $Extends = [
        "logo"  => '',
        "phone" => '',
    ];

    public function __construct()
    {
        foreach ($this->Extends as $k => $v) {
            $this->Extends[$k] = $this->db_get($k);
        }
    }

    private function db_get($field)
    {
        if (!($this->User instanceof UserItem)) {
            goto END;
        }
        $db      = $this->load("Mysql");
        $user_id = $this->User->getId();
        $data    = $db->select("wei_school_extends", "value", ["user_id[=]" => $user_id, ["field[=]" => $field]]);
        if (isset($data[0]["value"])) {
            return $data[0]["value"];
        }
        END:
        return '';
    }

    /**
     * 获取自己的扩展
     *
     * @param $key
     *
     * @return mixed|string
     */
    public function get($key)
    {
        if (isset($this->Extends[$key])) {
            return $this->Extends[$key];
        } else {
            return '';
        }
    }

    /**
     * 保存扩展信息
     *
     * @param $field
     * @param $val
     *
     * @return int
     */
    public function save($field, $val)
    {
        if (!($this->User instanceof UserItem)) {
            goto END;
        }
        $db          = $this->load("Mysql");
        $user_id     = $this->User->getId();
        $exist_field = function ($user_id, $field, $val) use ($db) {
            if (empty($val)) {
                return -2; ##-2 不更新
            }
            $data = $db->select("wei_school_extends", "id , value", ["user_id[=]" => $user_id, ["field[=]" => $field]]);
            if (!isset($data[0]["value"]) || empty($data)) {
                return -1;#insert
            }
            if ($data[0]["value"] == $val) {
                return -2;
            } else {
                return $data[0]["id"];#update
            }
        };
        $k_v         = $exist_field($user_id, $field, $val);
        if ($k_v == -1) {
            $db->update("wei_school_extends", [
                "user_id" => $user_id,
                "field"   => $field,
                "value"   => $val,
            ]);
        }
        if ($k_v > 0) {
            $db->update("wei_school_extends", [
                "value" => $val,
            ], [
                "id[=]" => $k_v
            ]);
        }
        return 0;
        END:
        return -1;
    }
}