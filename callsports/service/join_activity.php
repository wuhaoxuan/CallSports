<?php
  require_once ('../library/SQLManager.php');
  require_once('constant.php');
  $userId=$_POST['user_id'];
  $tableName=$userId."activity";
  $sqlManager=new SQLManager($tableName);
  $result=$sqlManager->updateValue($array("type",Constant::ACTIVITY_REGISTER));
  if($result)
  {
  	echo json_encode(array("result"=>"success"));
  }
  else
  {
  	echo json_decode(array("result"=>"failed"));
  }
?>