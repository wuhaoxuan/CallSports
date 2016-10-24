<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $userId=$_POST['userId'];
 if(empty($userId))
 {
 	echo "please post userId";
 	die();
 }
 $tableName="user_".$userId."_friendinfo";
 $sqlManager=new SQLManager($tableName);
 $result=$sqlManager->queryData(array("*"));
 $result=$result->fetchAll();
 $data=json_encode($result);
 $result="{friendinfo:$data}";
 echo $result;
?>