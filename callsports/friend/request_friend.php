<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $userId=$_POST["userId"];
 $requestUserId=$_POST['requestUserId'];
 $requestPortrait=$_POST['requestPortrait'];
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

if(empty($requestPortrait))
{
	echo "please post portrait";
	die();
}

 $sqlManager=new SQLManager($userId);
 $insertColum=array("user_id","portrait"."state");
 $insertValue=array("'$requestUserId","'$requestPortrait'",2);
 $sqlManager->insertValue
?>