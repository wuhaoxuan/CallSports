<?php
require_once('lib/SQLManager.php');
use callsports\library\SQLManager as SQLManager;

function register($username, $email, $password) {
// register new person with db
// return true or error message

   $sqlM = new SQLManager("localhost","root","123456","callSports","allUsers");
  // check if username is unique
   $result = $sqlM->queryData(array('*'),"username='$username'");
  //$result = $conn->query("select * from user where username='".$username."'");

  if (count($result)>0) {
    throw new Exception('That username is taken - go back and choose another one.');
  }

  // if ok, put in db
  $shaPasswd = sha1($password);
  $result = $sqlM->insertValue(array(username,passwd,email),array('$username','$shaPasswd', '$email'));
  
  //$result = $conn->query("insert into user values
                        // ('".$username."', sha1('".$password."'), '".$email."')");
  if (!$result) {
    throw new Exception('Could not register you in database - please try again later.');
  }

  return true;
}

function login($username, $password) {
// check username and password with db
// if yes, return true
// else throw exception

  // connect to db
  //$conn = db_connect();
	$sqlM = new SQLManager("localhost","root","123456","callSports","allUsers");
   // check if username is unique
  $shaPasswd = sha1($password);
	$result = $sqlM->queryData(array('*'),"username='$username'
											and passwd = '$shaPasswd'");
  
  //$result = $conn->query("select * from user
                        // where username='".$username."'
                        // and passwd = sha1('".$password."')");

  if (count($result)>0) {
     return true;
  } else {
     throw new Exception('Could not log you in.');
  }
}



?>
