<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 include '../library/imserver/api/rongcloud.php';
 require("./RongManager.php");
 $userId=$_POST["userId"];
 $requestUserId=$_POST['requestUserId'];
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
	$message="请求添加好友";
}

//state : 1 好友, 2 请求添加, 3 请求被添加, 4 请求被拒绝, 5拒绝请求，6 我被对方删除

//insert request friend info
 $tableName="user_".$userId."_friendinfo";
 $sqlManager=new SQLManager($tableName);
 $stn="insert into $tableName (user_id,state,message) select '$requestUserId',2,'$message' from dual where not exists (select user_id from $tableName where user_id='$requestUserId')";
 // $insertColum=array("user_id","state");
 // $insertValue=array("'$requestUserId'",2);
 // $sqlManager->insertValue($insertColum,$insertValue);
$sqlManager->exec($stn);

 //request frind insert info

 $tableName=$requestUserId."_friend_info";
 $sqlManager=new SQLManager($tableName);
 // $insertColum=array("user_id","state");
 // $insertValue=array("'$userId'",3);
 // $sqlManager->insertValue($insertColum,$insertValue);
  $stn="insert into $tableName (user_id,state,message) select '$userId',3,'$message' from dual where not exists (select user_id from $tableName where user_id='$userId')";
  $sqlManager->exec($stn);

//notify request friend
// $appKey = 'lmxuhwagxh61d';
// $appSecret = 'MADzJImCROOxS2';
// $jsonPath = "jsonsource/";
// $rongCloud = new RongCloud($appKey,$appSecret);
  $rongManager=new RongManager();
// 发送系统消息方法（一个用户向一个或多个用户发送系统消息，单条消息最大 128k，会话类型为 SYSTEM。每秒钟最多发送 100 条消息，每次最多同时向 100 人发送，如：一次发送 100 人时，示为 100 条消息。）
	$result = $rongManager->PublishSystem($userId, $requestUserId, 'RC:ContactNtf',"{\"content\":\"$message\",\"extra\":\"helloExtra\"}", 'thisisapush', '{\"pushData\":\"$message\"}', '0', '0');

	// $result = $rongCloud->message()->publishPrivate($userId, $requestUserId,'RC:ContactNtf',"{\"content\":\"hello\",\"extra\":\"helloExtra\",\"duration\":20}", 'thisisapush', '{\"pushData\":\"hello\"}', '4', '0', '0', '0');
	// $result = $rongCloud->message()->broadcast('userId1', 'RC:ContactNtf',"{\"content\":\"哈哈\",\"extra\":\"hello ex\"}", 'thisisapush', '{\"pushData\":\"hello\"}');

$data=array("result"=>"success");
echo json_encode($data);

?>