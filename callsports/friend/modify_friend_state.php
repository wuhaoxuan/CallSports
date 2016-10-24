<?php
 use \callsports\library\SQLManager;
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
  $tableName="user_".$userId."_friendinfo";
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
$result=array("result"=>"success");
echo json_encode($result);
?>