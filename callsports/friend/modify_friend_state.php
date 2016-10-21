<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $userId=$_POST['userId'];
 if(empty($userId))
 {
 	echo "please post userId";
 	die();
 }
 $state=$_POST['state'];
 if(empty($state))
 {
 	echo "please post state";
 	die();
 }
 
 $requestUserId=$_POST['requestUserId'];
 if(empty($requestUserId))
 {
 	echo "please post requestUserId";
 	die();
 }
 //update user table state;
function updataValue($userId,$state,$condition)
{
  $tableName="user_$userId";
  $sqlManager=new SQLManager($tableName);
  $condition="user_id='$requestUserId'";
  $valueArray=new Array("state"=>$state);
  $sqlManager->updateValue($valueArray,$condition);
}

if($state==1)
{
	updataValue($userId,1,"user_id='$requestUserId'");
	updataValue($requestUserId,1,"user_id='$userId'");
}
else if($state==4)
{
	updataValue($userId,4,"user_id='$requestUserId'");
	updataValue($requestUserId,4,"user_id='$userId'");
}
?>