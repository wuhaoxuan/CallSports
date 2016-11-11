<?php
   // include function files for this application
  require_once('user_auth_fns.php');
  // try{
	$user_id=$_POST['user_id'];
    	$password=$_POST['password'];

	$result=login($user_id, $password);
  if($result!=NULL && count($result)>0)
  {
    // $result=array_merge(array("result"=>"success"),$result);
    $result=array("result"=>"success")+$result;
  }
  else
  {
    $result=array("result"=>"failed");
  }
  echo json_encode($result);
	// echo json_encode(array('result' => 'success'));
 //    	exit;
 //   }catch (Exception $e){
 //   	  $errInfo = $e->getMessage();
 //      	  echo json_encode(array('result' => $errInfo));      
 //      	  exit;
   // }

?>
