<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $userId=$_POST['userId'];
 if(empty($userId))
 {
 	echo "please post userId";
 	die();
 }
 $tableName=$userId."_friend_info";
 $sqlManager=new SQLManager($tableName);
 $result=$sqlManager->queryData(array("*"));
 $result=$result->fetchAll();
 if(count($result)>0)
 {
  $data=json_encode($result);
  $result="{friendinfo:$data}";
 }
 else
 {
   $result="{}";
 }
 echo $result;
?>