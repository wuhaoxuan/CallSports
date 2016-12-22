<?php
require_once('../library/SQLManager.php');
use callsports\library\SQLManager as SQLManager;

try{

	//get the publish message
  $id=$_POST['id'];
   $user_id=$_POST['user_id'];
   $name=$_POST['name'];
   $time=$_POST['time'];
   $address=$_POST['address'];
   $latitude=$_POST['latitude'];
   $longitude=$_POST['longitude'];
   $total_num = $_POST['total_num'];
   $now_num = $_POST['now_num'];
   $cost = $_POST['cost'];
   $introduce = $_POST['introduce'];


   //if not exists create table all_activities
    $sqlM = new SQLManager("all_activities");

   	$tableDesc = array("id varchar(50) not null primary key "
   						,"user_id varchar(30) not null"
   						,"name varchar(40)  not null "
   						,"time varchar(30) not null"
   						,"address  text  not null"
              ,"latitude double not null"
              ,"longitude double not null"
   						,"total_num varchar(30) not null"
   						,"now_num varchar(30) not null"
   						,"cost varchar(20) not null"
   						,"introduce text  not null");

  	$result = $sqlM->createTable($tableDesc);

  	if(!$result)
        throw new Exception("cteateTable  all_activities error");


  //insert to all_activities
    $result = $sqlM->insertValue(array(id,user_id,name,time,address,latitude,longitude,total_num,now_num,cost,introduce)
    							,array("'".$id."'","'".$user_id."'","'".$name."'","'".$time."'", "'".$address."'","'".$latitude."'","'".$longitude."'","'".$total_num."'","'".$now_num."'","'".$cost."'" ,"'".$introduce."'"));
  
  
  if (!$result) {
    throw new Exception('Could not insert your activity in database - please try again later.');
  }

  echo json_encode(array('result' => 'success'));      

}catch(Exception  $e){
	  $errInfo = $e->getMessage();
      echo json_encode(array('result' => $errInfo));      
      exit;
}


?>

