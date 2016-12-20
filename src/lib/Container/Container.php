<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/19
 * Time: 23:18
 */

namespace WEI\Lib\Container;


class Container implements ContainerInterface,\ArrayAccess
{
    public $aData;
    public $aCB;

    public static function __INIT__($aConf){
        $Obj = new self();
        foreach ($aConf as $sK => $sV) {
            $Obj[$sK] = $sV;
        }
        return $Obj;
    }

    public function get($id)
    {
        if (!isset($this->aData[$id])) {
            if (!isset($this->aCB[$id])) {
               exit($id."not in Container");
            }
            $this->aData[$id] = $mV = call_user_func($this->aCB[$id], $this);
        } else {
            $mV = $this->aData[$id];
        }
        return $mV;
    }

    public function has($id)
    {
        return isset($this->aData[$id]) || isset($this->aCB[$id]);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
    public function offsetSet($offset, $value)
    {
        if ($value instanceof \Closure) {
            $this->aCB[$offset] = $value;
        } else {
            $this->aData[$offset] = $value;
        }
    }
    public function offsetUnset($offset)
    {
        if (isset($this->aData[$offset])) {
            unset($this->aData[$offset]);
        }
        if (isset($this->aCB[$offset])) {
            unset($this->aCB[$offset]);
        }
    }

}