<?php
require_once('../library/SQLManager.php');
use callsports\library\SQLManager as SQLManager;

try{

	//get the publish message
   $user_id=$_POST['user_id'];
   $name=$_POST['name'];
   $time=$_POST['time'];
   $address=$_POST['address'];
   $total_num = $_POST['total_num'];
   $now_num = $_POST['now_num'];
   $cost = $_POST['cost'];
   $cost_type = $_POST['cost_type'];
   $introduce = $_POST['introduce'];

   //if not exists create table all_activities
    $sqlM = new SQLManager("all_activities");

   	$tableDesc = array("id int not null primary key auto_increment"
   						,"user_id varchar(30) not null"
   						,"name varchar(40)  not null "
   						,"time varchar(30) not null"
   						,"address  text  not null"
   						,"total_num int not null"
   						,"now_num int not null"
   						,"cost int not null"
   						,"cost_type int not null"
   						,"introduce text  not null");

  	$result = $sqlM->createTable($tableDesc);

  	if(!$result)
        throw new Exception("cteateTable  all_activities error");


  //insert to all_activities
    $result = $sqlM->insertValue(array(user_id,name,time,address,total_num,now_num,cost,cost_type,introduce)
    							,array("'".$user_id."'","'".$name."'","'".$time."'", "'".$address."'","'".$total_num."'","'".$now_num."'","'".$cost."'" ,"'".$cost_type."'","'".$introduce."'"));
  
  
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

