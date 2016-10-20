<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $userId=$_POST['userId'];
 if(empty($userId))
 {
 	echo "please post userId";
 	die();
 }
 $tableName="user_".$userId;
 $sqlManager=new SQLManager($tableName);
 $result=$sqlManager->queryData(array("*"));
 echo json_encode($result);
?>