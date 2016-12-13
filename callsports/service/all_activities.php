<?php
require_once('../library/SQLManager.php');
use callsports\library\SQLManager as SQLManager;

	try{
		  $user_id=$_POST['user_id'];	
  		  $offset=$_POST['offset'];
   		  $total_num=$_POST['total_num'];

		$sqlM = new SQLManager("all_activities");
   // check if username is unique
      
	$result = $sqlM->queryData(array('*'),"") ;
	$result_arr = $result->fetchAll();
  $num =  count($result_arr);

  if ($num  >  0) {
         if ($offset >= 0 && $offset < $num) {
      $total_offset = $num - $offset;
      $actual_offset = $total_offset > $total_num ? $total_num : $total_offset;

      $final_result = array();
      for($i=0;$i<$actual_offset;$i++){
        array_push($final_result, $result_arr[$i+$offset]);
      }
    $result=json_encode($final_result);
    echo json_encode(array("result"=>$result)); 
    }else{
    //
      echo json_encode(array()); 
     }      
     }else {
      echo json_encode(array()); 
    }

	}catch(Exception $e){
        $errInfo = $e->getMessage();
     	echo json_encode(array('result' => $errInfo));      
      	exit;
	}
?>

