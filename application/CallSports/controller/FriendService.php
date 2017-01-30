<?php
namespace app\callsports\controller;
require_once('../extend/imserver/api/rongcloud.php');
use app\callsports\model\FriendsInfoModel;
use think\Request;

class FriendService
{
    private $appKey = 'lmxuhwagxh61d';
    private $appSecret = 'MADzJImCROOxS2';
    private $rongCloud;
    protected $table = "ww_friendsinfo";

    public function __construct()
    {
        $this->rongCloud = new \RongCloud($this->appKey, $this->appSecret);
    }

    public function getToken($userId, $userName, $portraitUri = null)
    {
        if (empty($portraitUri)) {
            $portraitUri = 'http://www.rongcloud.cn/images/logo.png';
        }
        // 获取 Token 方法
        $result = $this->rongCloud->User()->getToken($userId, $userName, $portraitUri);
        print_r($result);
        echo "\n";
    }

    public function getFriendsInfo($userId)
    {
        $friendsInfoModel = new FriendsInfoModel($userId);
        return $friendsInfoModel->getFriendsInfo($userId);
    }

    public function modifyFriendState($userId, $requestUserId, $accept)
    {
        $friendsInfoModel = new FriendsInfoModel($userId);
        $result = $friendsInfoModel->modifyFriendState($userId, $requestUserId, $accept);
        if (!empty($result)) {
            $result = $result['result'];
            if ("accept" == $result) {
                $this->publishPrivate($userId, $requestUserId);
            } else if ("deny" == $result) {

            }
        }
    }

    public function publishPrivate($userId, $requestUserId)
    {
        // 发送单聊消息方法（一个用户向另外一个用户发送消息，单条消息最大 128k。每分钟最多发送 6000 条信息，每次发送用户上限为 1000 人，如：一次发送 1000 人时，示为 1000 条消息。）
        $rongManager = new \RongManager();
        $message = "你们是朋友了，现在你们可以聊天了";
        $rongManager->publishPrivate($userId, $requestUserId, 'RC:InfoNtf', "{\"message\":\"$message\",\"extra\":\"helloExtra\",\"duration\":20}", 'thisisapush', '{\"pushData\":\"$message\"}', '4', '0', '0', '0');
        $rongManager->publishPrivate($requestUserId, $userId, 'RC:InfoNtf', "{\"message\":\"$message\",\"extra\":\"helloExtra\",\"duration\":20}", 'thisisapush', '{\"pushData\":\"$message\"}', '4', '0', '0', '0');
    }

    public function requestFriend($userId, $requestUserId, $message)
    {

        $friendsInfoModel = new FriendsInfoModel();
        $result = $friendsInfoModel->requestFriend($userId, $requestUserId, $message);
//        $rongManager=new \RongManager();
         // 发送系统消息方法（一个用户向一个或多个用户发送系统消息，单条消息最大 128k，会话类型为 SYSTEM。每秒钟最多发送 100 条消息，每次最多同时向 100 人发送，如：一次发送 100 人时，示为 100 条消息。）
//        $messageResult = $rongManager->PublishSystem($userId, $requestUserId, 'RC:ContactNtf',"{\"content\":\"$message\",\"extra\":\"helloExtra\"}", 'thisisapush', '{\"pushData\":\"$message\"}', '0', '0');
        return $result;
    }

    public function searchFriend($requestUserId)
    {
        $friendsInfoModel = new FriendsInfoModel();
        $searchResult=$friendsInfoModel->searchFriend($requestUserId);
        if($searchResult==null)
        {
            return ['result'=>'not found'];
        }
        else
        {
             return $searchResult;
        }
    }

}