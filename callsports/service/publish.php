<?php
require_once('../library/SQLManager.php');
use callsports\library\SQLManager as SQLManager;


function create_uuid($prefix = ""){    //可以指定前缀
    $str = md5(uniqid(mt_rand(), true));   
    $uuid  = substr($str,0,8) . '-';   
    $uuid .= substr($str,8,4) . '-';   
    $uuid .= substr($str,12,4) . '-';   
    $uuid .= substr($str,16,4) . '-';   
    $uuid .= substr($str,20,12);   
    return $prefix . $uuid;
}

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
   						,"name varchar(40) not null"
   						,"time varchar(30) not null"
   						,"address  text not null"
              ,"latitude double not null"
              ,"longitude double not null"
   						,"total_num varchar(30) not null"
   						,"now_num varchar(30) not null"
   						,"cost varchar(20) not null"
   						,"introduce text");

  	$result = $sqlM->createTable($tableDesc);

  	if(!$result)
        throw new Exception("cteateTable  all_activities error");

  $uuid=create_uuid();
  //insert to all_activities
    $result = $sqlM->insertValue(array(id,user_id,name,time,address,latitude,longitude,total_num,now_num,cost,introduce)
    							,array("\"$uuid\"","'".$user_id."'","'".$name."'","'".$time."'", "'".$address."'","'".$latitude."'","'".$longitude."'","'".$total_num."'","'".$now_num."'","'".$cost."'" ,"'".$introduce."'"));
    
  
  if (!$result) {
   echo json_encode(array("result"=>'Could not insert your activity in database - please try again later.'));
  }

   // $resultSignal=$sqlM->insertValue(array(id,user_id,activity,type),array());

  echo json_encode(array('result' => 'success'));      

}catch(Exception  $e){
	   $errInfo = $e->getMessage();
      echo json_encode(array('result' => $errInfo));      
      exit;
}


?>

