<?php
 use \callsports\library\SQLManager;
 include '../library/imserver/api/rongcloud.php';
 require("../library/SQLManager.php");
 $userId=$_POST['userId'];
 if(empty($userId))
 {
 	echo "please post userId";
 	die();
 }
 $requestUserId=$_POST['requestUserId'];
 if(empty($requestUserId))
 {
 	echo "please post requestUserId";
 	die();
 }

 $access=$_POST['accept'];
 if(empty($access))
 {
 	echo "Please post accept";
 	die();
 }
 //update user table state;
function updateValue($userId,$state,$condition)
{
  $tableName=$userId."_friend_info";
  $sqlManager=new SQLManager($tableName);
  $valueArray=array("state",$state);
  $sqlManager->updateValue($valueArray,$condition);
}

if("true"==$access)
{
	updateValue($userId,1,"user_id='$requestUserId'");
	updateValue($requestUserId,1,"user_id='$userId'");
}
else
{
	updateValue($userId,4,"user_id='$requestUserId'");
	updateValue($requestUserId,5,"user_id='$userId'");
}


	// 发送单聊消息方法（一个用户向另外一个用户发送消息，单条消息最大 128k。每分钟最多发送 6000 条信息，每次发送用户上限为 1000 人，如：一次发送 1000 人时，示为 1000 条消息。）
$appKey = 'lmxuhwagxh61d';
$appSecret = 'MADzJImCROOxS2';
$jsonPath = "jsonsource/";
$rongCloud = new RongCloud($appKey,$appSecret);
   $message="你们是朋友了，现在你们可以聊天了";
	$result = $rongCloud->Message()->publishPrivate($userId, $requestUserId, 'RC:InfoNtf',"{\"message\":\"$message\",\"extra\":\"helloExtra\",\"duration\":20}", 'thisisapush', '{\"pushData\":\"$message\"}', '4', '0', '0', '0');
$result = $rongCloud->Message()->publishPrivate($requestUserId, $userId, 'RC:InfoNtf',"{\"message\":\"$message\",\"extra\":\"helloExtra\",\"duration\":20}", 'thisisapush', '{\"pushData\":\"$message\"}', '4', '0', '0', '0');
$result=array("result"=>"success");
echo json_encode($result);
?>