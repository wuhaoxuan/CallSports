<?php
   // include function files for this application
  require_once('user_auth_fns.php');
  try{
	$username=$_POST['username'];
    	$passwd=$_POST['passwd'];

	login($username, $passwd);
	echo json_encode(array('result' => 'success'));
    	exit;
   }catch (Exception $e){
   	  $errInfo = $e->getMessage();
      	  echo json_encode(array('result' => $errInfo));      
      	  exit;
   }

?>