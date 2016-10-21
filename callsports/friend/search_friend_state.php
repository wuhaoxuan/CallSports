<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 include '../library/imserver/api/rongcloud.php';
 $userId=$_POST['userId'];
 if(empty($userId))
 {
  	echo "please post userId";
  	die();
  }
  $tableName="user_$userId";
  $sqlManager=new SQLManager($tableName);
  $queryColum=array("*");
  $stm=$sqlManager->queryData($queryColum);
  $result=$stm->fetchAll();
  $result=json_encode($result);
  $result=json_encode(array("{state:$result}"));
  echo $result;
?>