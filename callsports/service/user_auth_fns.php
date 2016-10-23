<?php
require_once('../library/SQLManager.php');
use callsports\library\SQLManager as SQLManager;

function register($user_id, $password,$nick_name,$email,$sex,$phone_num,$head_protrait) {
// register new person with pdo
// return true or error message

   $sqlM = new SQLManager("all_users");

   $tableDesc = array("user_id char(30)  not null primary key","password char(40)  not null ","nick_name char(30) not null","email  char(30)  not null","sex char(5) not null",
                                          "phone_num char(11) not null","head_protrait char(60)  not null","reg_date TIMESTAMP" );

   $result = $sqlM->createTable($tableDesc);
    if(!$result)
        throw new Exception("cteateTable  all_users error");
        
  // check if username is unique
   $result = $sqlM->queryData(array('*'),"user_id='$user_id'");
   $num =  count($result->fetchAll());
  if ($num  >0) {
    throw new Exception('That userId is taken - go back and choose another one.');
  }

  // if ok, put in db
  $shaPasswd = sha1($password);

  $result = $sqlM->insertValue(array(user_id,password,nick_name,email,sex,phone_num,head_protrait),array("'".$user_id."'","'".$shaPasswd."'", "'".$nick_name."'","'".$email."'","'".$sex."'","'".$phone_num."'" ,"'".$head_protrait."'"));
  
  
  if (!$result) {
    throw new Exception('Could not register you in database - please try again later.');
  }

 //need  to  create persion db  if error need delete the have  insert row
  

  return true;
}

function login($userId, $password) {
// check username and password with db
  // connect to db

	$sqlM = new SQLManager("all_users");
   // check if username is unique
        $shaPasswd = sha1($password);
	$result = $sqlM->queryData(array('*'),"user_id='$userId'   and password = '$shaPasswd'") ;
        $num =  count($result->fetchAll());

        if ($num  >  0) {
          return true;
          
        }else {
            throw new Exception('Could not log you in.');
        }
        

}



?>
