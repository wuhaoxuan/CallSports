<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $requestUserId=$_POST['requestUserId'];
 if(empty($requestUserId))
 {
 	echo "please post requestUserId";
 	die();
 }
 
 $tableName="all_users";
 $sqlManager=new SQLManager($tableName);
 $sqlSen=array("*");
 $condition="username='$requestUserId'";
 $result=$sqlManager->queryData($sqlSen, $condition);
 if(empty($result))
 {
 	$result=array("result"=>"not found");
 	echo json_encode($result);
 	die();
 }
 else
 {
 	$data=array();
 	$data["result"]="found";
 	$finalResult=array_merge($data,$result);
 	$finalResult=json_encode($finalResult);
 	echo $finalResult;
 	die();
 }
?>