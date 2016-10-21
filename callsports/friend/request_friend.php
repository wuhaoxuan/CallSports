<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 include '../library/imserver/api/rongcloud.php';
 $userId=$_POST["userId"];
 $requestUserId=$_POST['requestUserId'];
 $requestPortrait=$_POST['requestPortrait'];
 $message=$_POST['message'];
 if(empty($userId))
 {
 	echo "please post userid";
 	die();
 }

if(empty($requestUserId))
{
	echo "please post requestUserId";
	die();
}

// if(empty($requestPortrait))
// {
// 	echo "please post portrait";
// 	die();
// }

if(empty($message))
{
	echo "please post message";
	die();
}

//state : 1 好友, 2 请求添加, 3 请求被添加, 4 请求被拒绝, 5 我被对方删除

//insert request friend info
 $tableName="user_$userId";
 $sqlManager=new SQLManager($tableName);
 $insertColum=array("user_id","portrait","state");
 $insertValue=array("'$requestUserId'","'$requestPortrait'",2);
 $sqlManager->insertValue($insertColum,$insertValue);

 //request frind insert info

 $tableName="user_$requestUserId";
 $sqlManager=new SQLManager($tableName);
 $insertColum=array("user_id","portrait","state");
 $insertValue=array("'$userId'","'$requestPortrait'",3);
 $sqlManager->insertValue($insertColum,$insertValue);

//notify request friend
$appKey = 'lmxuhwagxh61d';
$appSecret = 'MADzJImCROOxS2';
$jsonPath = "jsonsource/";
$rongCloud = new RongCloud($appKey,$appSecret);
// 发送系统消息方法（一个用户向一个或多个用户发送系统消息，单条消息最大 128k，会话类型为 SYSTEM。每秒钟最多发送 100 条消息，每次最多同时向 100 人发送，如：一次发送 100 人时，示为 100 条消息。）
	$result = $rongCloud->message()->PublishSystem($userId, $requestUserId, 'RC:ContactNtf',"{\"content\":\"hello\",\"extra\":\"helloExtra\"}", 'thisisapush', '{\"pushData\":\"hello\"}', '0', '0');

	// $result = $rongCloud->message()->publishPrivate($userId, $requestUserId,'RC:ContactNtf',"{\"content\":\"hello\",\"extra\":\"helloExtra\",\"duration\":20}", 'thisisapush', '{\"pushData\":\"hello\"}', '4', '0', '0', '0');
	// $result = $rongCloud->message()->broadcast('userId1', 'RC:ContactNtf',"{\"content\":\"哈哈\",\"extra\":\"hello ex\"}", 'thisisapush', '{\"pushData\":\"hello\"}');

$data=array("result"=>"success");
echo json_encode($data);

?>