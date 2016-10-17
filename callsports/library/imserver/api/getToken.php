<?php
include 'rongcloud.php';
$appKey = 'lmxuhwagxh61d';
$appSecret = 'MADzJImCROOxS2';
$jsonPath = "jsonsource/";
$RongCloud = new RongCloud($appKey,$appSecret);

$userId=$_POST["userId"];
$userName=$_POST["name"];
$portraitUri=$_POST["portraitUri"];
if(empty($portraitUri))
{
	$portraitUri='http://www.rongcloud.cn/images/logo.png';
}
// 获取 Token 方法
	$result = $RongCloud->User()->getToken($userId, $userName,$portraitUri);
	print_r($result);
	echo "\n";
?>
