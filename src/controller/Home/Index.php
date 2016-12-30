<?php
/**
 * Created by PhpStorm.
 * User: lyang
 * Date: 2016/12/20
 * Time: 0:25
 */

namespace WEI\Controller\Home;


use WEI\Controller\RestCommon;
use WEI\Domain\Ad\AdItem;
use WEI\Domain\Ad\AdService;
use WEI\Domain\User\UserItem;
use WEI\Lib\Error\Error;

class Index extends RestCommon
{
    /**
     * 创建ad
     * @request ad[id]
     * @request ad[name]
     * @request ad[picture]
     * @request ad[content]
     * @request ad[position]
     * @request ad[info]
     */
    public function createadAction(){
        /** @var UserItem $User */
        $User = $this->getUser();
        if($User->getRank() < 11){
            goto ERROR_QUAN;
        }
        $req = $this->REQ->request();
        if(!isset($req["ad"])){
            goto ERROR_PARAMS;
        }
        $ad = $req["ad"];
        /** @var AdService $ad_server */
        $ad_server = $this->domain("Ad","AdService");
        /** @var AdItem $ad_item */
        $ad_item = $ad_server->buildAd($ad);
        return $this->finish(Error::ERR_NONE,["result"=>$ad_item->save()]);
        ERROR_QUAN:
        return $this->finish(Error::ERR_QUANXIAN,'');
        ERROR_PARAMS:
        return $this->finish(Error::ERR_PARAM,'');
    }

    /**
     * 通过position获取ad
     * @request position
     */
    public function getadbypositionAction(){
        $req = $this->REQ->request();
        if(!isset($req["position"])){
            goto ERROR_PARAMS;
        }
        $position = $req["position"];
        /** @var AdService $ad_server */
        $ad_server = $this->domain("Ad","AdService");
        $item = $ad_server->getAdByPosition($position);
        return $this->finish(Error::ERR_NONE,$item);
        ERROR_PARAMS:
        return $this->finish(Error::ERR_PARAM,'');
    }


    /**
     * 通过id获取ad
     * @request id
     */
    public function getadbyidAction(){
        $req = $this->REQ->request();
        if(!isset($req["id"])){
            goto ERROR_PARAMS;
        }
        $id = $req["id"];
        /** @var AdService $ad_server */
        $ad_server = $this->domain("Ad","AdService");
        $item = $ad_server->getAdByPosition($id);
        return $this->finish(Error::ERR_NONE,$item);
        ERROR_PARAMS:
        return $this->finish(Error::ERR_PARAM,'');
    }
    /**
     *通过position数组获取ad
     * @request position
     */
    public function getadbypositionarrayAction(){
        $req = $this->REQ->request();
        $size = 25;
        $position = isset($req["position"])?$req["position"]:0;
        if(!is_array($position)){
            goto ERROR_PARAMS;
        }
        /** @var AdService $ad_server */
        $ad_server = $this->domain("Ad","AdService");
        $item = $ad_server->getAdByPosition($position);
        return $this->finish(Error::ERR_NONE,$item);
        ERROR_PARAMS:
        return $this->finish(Error::ERR_PARAM,'');
    }
    /**
     *创建条件获取ad
     * @request page
     */
    public function getadbylistAction(){
        $req = $this->REQ->request();
        $size = 25;
        $page = isset($req["page"])?$req["page"]:1;
        $page = intval($page) > 0?intval($page):1;
        $page--;
        /** @var AdService $ad_server */
        $ad_server = $this->domain("Ad","AdService");
        $where=[
            "LIMIT"=>[
                $size*$page,$size
            ]
        ];
        $item = $ad_server->getAd($where);
        return $this->finish(Error::ERR_NONE,$item);
        ERROR_PARAMS:
        return $this->finish(Error::ERR_PARAM,'');
    }

    /**
     * 删除文章
     * @request id
     */
    public function rmadAction(){
        $req = $this->REQ->request();
        if(!isset($req["id"])){
            goto ERROR_PARAMS;
        }
        $id = $req["id"];
        /** @var AdService $ad_server */
        $ad_server = $this->domain("Ad","AdService");
        $item = $ad_server->getAdByPosition($id);
        return $this->finish(Error::ERR_NONE,$item->rm());
        ERROR_PARAMS:
        return $this->finish(Error::ERR_PARAM,'');
    }
}