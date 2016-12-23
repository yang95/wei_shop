<?php

/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/22
 * Time: 19:04
 */

namespace WEI\Console\Reflact;

use WEI\Console\CliCommon;

class Reflact extends CliCommon
{
    const CONFIG = [
        [
            "Home",
            "Test",
        ],
        [
            "Tool",
            "Qiniu",
        ],
    ];

    /**
     * 生成文档输出到doc
     */
    public function run()
    {
        $content = "";
        foreach (self::CONFIG as $v) {
            $iClass = sprintf("WEI\\Controller\\%s\\%s",
                $v[0],
                $v[1]
            );
            if (class_exists($iClass)) {
                $Ref     = new \ReflectionClass($iClass);
                $aMethod = $Ref->getMethods(\ReflectionMethod::IS_PUBLIC);
                foreach ($aMethod as $Method) {
                    $methob_name = $Method->getName();
                    if (substr($methob_name, -6) != "Action") {
                        continue;
                    }
                    $str = sprintf(
                        "%s%s%s%s",
                        "## url地址： /v1/" . $v[0] ."/".$v[1] ."/".substr($methob_name,0,-6). ".action\n",
                        "\n```\n文档：\n\n     " . $Method->getDocComment() . "\n",
                        "\n\n类地址： \n\n     " . $iClass ."->". $methob_name. "\n```\n",
                        "\n\n\n\n"
                    );
                    $content .= $str;
                }
            }
        }
        file_put_contents("doc/Interface/doc_" . date("Y-m-d-H-i-s") . ".md", $content);
    }
}