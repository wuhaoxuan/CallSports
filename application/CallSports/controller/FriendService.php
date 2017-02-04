<?php
namespace app\callsports\controller;
use app\callsports\model\FriendsInfoModel;
use imserver\api\RongManager;

class FriendService
{

    protected $table = "ww_friendsinfo";
    private $rongManager;

    public function __construct()
    {

        $this->rongManager=new RongManager();
    }

    public function getToken($userId, $userName, $portraitUri = null)
    {
        if (empty($portraitUri)) {
            $portraitUri = 'http://www.rongcloud.cn/images/logo.png';
        }
        return $this->rongManager->getToken($userId,$userName,$portraitUri);
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

    public function publishPrivate($userId, $requestUserId,$message)
    {
        // 发送单聊消息方法（一个用户向另外一个用户发送消息，单条消息最大 128k。每分钟最多发送 6000 条信息，每次发送用户上限为 1000 人，如：一次发送 1000 人时，示为 1000 条消息。）
//        $message = "你们是朋友了，现在你们可以聊天了";
        $this->rongManager->publishPrivate($userId, $requestUserId, 'RC:TxtMsg',$message,'', $message, $message, '4', '0', '0', '0');
        $this->rongManager->publishPrivate($requestUserId, $userId, 'RC:TxtMsg',$message,'', $message, $message, '4', '0', '0', '0');

//        $result =$rongManager->rongCloud->message()->publishPrivate('d', 'e', 'RC:TxtMsg',"{\"content\":\"hello\",\"extra\":\"helloExtra\"}", 'thisisapush', '{\"pushData\":\"hello\"}', '4', '0', '0', '0');
//        echo "publishPrivate    ";
//        print_r($result);
//        echo "\n";
    }

    public function requestFriend($userId, $requestUserId, $message)
    {

        $friendsInfoModel = new FriendsInfoModel();
        $result = $friendsInfoModel->requestFriend($userId, $requestUserId, $message,$extra='');
        $pushContent="$userId"." 请求添加好友";
        $extra=\Constant::FRIEND_REQUEST;
         // 发送系统消息方法（一个用户向一个或多个用户发送系统消息，单条消息最大 128k，会话类型为 SYSTEM。每秒钟最多发送 100 条消息，每次最多同时向 100 人发送，如：一次发送 100 人时，示为 100 条消息。）
        $messageResult = $this->rongManager->publishSystem($userId, $requestUserId, \Constant::FRIEND_REQUEST,$message, $extra, $pushContent, $message, 0, 0);
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

    public function getUserInfo($useId)
    {
        $friendsInfoModel = new FriendsInfoModel();
       return $friendsInfoModel->getUserInfo($useId);
    }

    public function friendTest($userId, $requestUserId)
    {
//        $this->rongManager->publishPrivate($userId,$requestUserId,\Constant::FRIEND_REQUEST,"hello world");
//        $this->publishPrivate($userId,$requestUserId,'你们是朋友了');
//        $rongManager = new RongManager();
//        $message='You are friends';
//        $rongManager->publishSystem($userId, $requestUserId, 'RC:InfoNtf',"{\"content\":\"$message\",\"extra\":\"helloExtra\"}", 'thisisapush', "{\"pushData\":\"$message\"}", '0', '0');

    }
}