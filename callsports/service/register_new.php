<?php
  require_once('user_auth_fns.php');
  //create short variable names
  $user_id=$_POST['user_id'];
  $password=$_POST['password'];
  $nick_name=$_POST['nick_name'];
   $email=$_POST['email'];
   $sex = $_POST['sex'];
   $phone_num = $_POST['phone_num'];
   $head_protrait = $_POST['head_protrait'];
  try   {
    // check forms filled in
    // attempt to register
    // this function can also throw an exception
    register($user_id, $password,$nick_name,$email,$sex,$phone_num,$head_protrait) ;
       // register("user_id", "password","nick_name","email","se","phone_num","head_protrait") ;
 
    //put the result to phone	
    echo json_encode(array('result' => 'success'));
    exit;
  }
  catch (Exception $e) {
      $errInfo = $e->getMessage();
      echo json_encode(array('result' => $errInfo));      
      exit;
  }
?>
