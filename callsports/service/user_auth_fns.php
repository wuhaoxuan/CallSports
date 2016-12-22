<?php
require_once('../library/SQLManager.php');
use callsports\library\SQLManager as SQLManager;

function register($user_id, $password,$nick_name,$email,$sex,$phone_num,$head_protrait) {
// register new person with pdo
// return true or error message

   $sqlM = new SQLManager("all_users");

   $tableDesc = array("user_id varchar(30)  not null primary key","password varchar(40)  not null ","nick_name varchar(30) not null","email  varchar(60)  not null","sex varchar(5) not null",
                                          "phone_num varchar(11) not null","protrait text  not null","reg_date TIMESTAMP" );

  $result = $sqlM->createTable($tableDesc);
  if(!$result)
        throw new Exception("cteateTable  all_users error");

  //create user friend_info table and insert data 
  $tableFriendName = $user_id."_friend_info";
  $sqlFriend = new SQLManager($tableFriendName);       
  $tableDesc = array("id int not null primary key auto_increment","user_id varchar(30)  not null","email  varchar(60)","protrait text  not null","state int",
                                          "message text");

   $result = $sqlFriend->createTable($tableDesc);
    if(!$result)
        throw new Exception("cteateTable $tableFriendName error");

  //create user activity table     and insert data 
  $tableActivityName = $user_id."_activity";
  $sqlActivity = new SQLManager($tableActivityName);
       
  $tableDesc = array("id int not null primary key auto_increment","user_id varchar(30)  not null","activity text","type  int");

   $result = $sqlActivity->createTable($tableDesc);
   if(!$result)
   {
    $sqlFriend->deleteTable($tableFriendName);
    throw new Exception("cteateTable $tableActivityName error");
   }
   $result = $sqlActivity->insertValue(array(user_id),array("'".$user_id."'"));
   if (!$result) {
        $sqlFriend->deleteTable($tableFriendName);
        $sqlActivity->deleteTable($tableActivityName);
        throw new Exception('Could not insert you in $tableActivityName - please try again later.');
   }



  // check if username is unique
   $result = $sqlM->queryData(array('*'),"user_id='$user_id'");
   $num =  count($result->fetchAll());
  if ($num  >0) {
    throw new Exception('That userId is taken - go back and choose another one.');
  }

  // check if eamil is unique
  $result = $sqlM->queryData(array('*'),"email='$email'");
  $num =  count($result->fetchAll());
  if ($num  >0) {
    throw new Exception('That email is taken - go back and choose another one.');
  }

  // if ok, put in db
  $shaPasswd = sha1($password);

  $result = $sqlM->insertValue(array(user_id,password,nick_name,email,sex,phone_num,protrait),array("'".$user_id."'","'".$shaPasswd."'", "'".$nick_name."'","'".$email."'","'".$sex."'","'".$phone_num."'" ,"'".$head_protrait."'"));
  
  
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
        return $result->fetch();
        // echo json_encode($result->fetch());
        // $num =  count($result->fetchAll());
        // if ($num  >  0) {
        //   return true;
          
        // }else {
        //     throw new Exception('Could not log you in.');
        // }
        

}



?>
