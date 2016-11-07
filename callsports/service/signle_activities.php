<?php
require_once('../library/SQLManager.php');
use callsports\library\SQLManager as SQLManager;

	try{
		  $user_id=$_POST['user_id'];
		  $name = $_POST['name'];
  		  $offset=$_POST['offset'];
   		  $total_num=$_POST['total_num'];

		$sqlM = new SQLManager("all_activities");
   // check if username is unique
      
	$result = $sqlM->queryData(array('*'),"name='$name'");
	$result_arr = $result->fetchAll();
    $num =  count($result_arr);

    if ($num  >  0) {
        echo json_encode($result_arr);   
          
     }else {
     	echo json_encode(array('')); 
    }

	}catch(Exception $e){
        $errInfo = $e->getMessage();
     	echo json_encode(array('result' => $errInfo));      
      	exit;
	}
?>