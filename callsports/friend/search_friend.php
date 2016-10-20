<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $userId=$_POST['userId'];
 $requestUserId=$_POST['requestUserId'];
 if(empty($userId))
 {
 	echo "please post userId";
 	die();
 }

 if(empty($requestUserId))
 {
 	echo "please post requestUserId";
 	die();
 }
 
 $tableName="user_".$userId;
 $sqlManager=new SQLManager($tableName);
 $sqlSen=array("*");
 $condition="userId='$userId'";
 $result=$sqlManager->queryData($sqlSen, $condition);

?>