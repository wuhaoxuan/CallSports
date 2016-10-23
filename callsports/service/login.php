<?php
   // include function files for this application
  require_once('user_auth_fns.php');
  try{
	$user_id=$_POST['user_id'];
    	$password=$_POST['password'];

	login($user_id, $password);
	echo json_encode(array('result' => 'success'));
    	exit;
   }catch (Exception $e){
   	  $errInfo = $e->getMessage();
      	  echo json_encode(array('result' => $errInfo));      
      	  exit;
   }

?>
