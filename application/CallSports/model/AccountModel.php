<?php
  namespace app\callsports\model;
  use think\Db;
  use think\Model;
  class AccountModel extends Model
  {

      protected $table="all_users";
      protected $user_id='';

      private function register($user_id,$password, $nick_name, $email, $sex, $phone_num, $head_protrait)
      {
          //create all_users table;
          $createAllUsersTable="create table if NOT EXISTS  all_users (user_id varchar(30)  not null primary key,password varchar(40) not null,nick_name varchar(30) not null,email  varchar(60)  not null,sex varchar(5) not null,
                                          phone_num varchar(11) not null,protrait text  not null,reg_date TIMESTAMP)";
          Db::execute($createAllUsersTable);

          $createFriendInfoTable="create table if NOT EXISTS $user_id"."_friendsinfo (id int not null primary key auto_increment,user_id varchar(30) not null,email varchar(60),protrait text  not null,state int,
                                          message text)";
          Db::execute($createFriendInfoTable);

          $createActivityTable="create table if NOT EXISTS $user_id"."_activity (id int not null primary key AUTO_INCREMENT,uuid text not null,name text,type  int,members text,now_num int)";
          Db::execute($createActivityTable);

//          $test=new RegisterNewModel();
//          $test->data(['user_id'=>'223','password'=>'132231','nick_name'=>'li','email'=>'13222','sex'=>'male','phone_num'=>'111111','protrait'=>'123']);
//          $test->save();
          $result=self::where('user_id',$user_id)->find();
          if(empty($result))
          {
              $shaPasswd = sha1($password);
              $this->data(['user_id'=>"$user_id",'password'=>"$shaPasswd",'nick_name'=>"$nick_name",'email'=>"$email",'sex'=>"$sex",'phone_num'=>"$phone_num",'protrait'=>"$head_protrait"]);
              $this->save();
          }
          else
          {
             return ['result'=>'user has registered'];
          }

      }


      public function registerNew($user_id,$password, $nick_name, $email, $sex, $phone_num, $head_protrait)
      {

          try   {
              // check forms filled in
              // attempt to register
              // this function can also throw an exception
              $hasRegistered=$this->register($user_id, $password,$nick_name,$email,$sex,$phone_num,$head_protrait);
              if(!empty($hasRegistered))
              {
                  return $hasRegistered;
              }
              //put the result to phone
              return ['result' =>'success'];
          }
          catch (Exception $e) {
              $errInfo = $e->getMessage();
              return ['result' => $errInfo];
          }

      }

      public function login($userId, $password)
      {
          $shaPassword = sha1($password);
          $result=self::where(['user_id'=>$userId,'password'=>$shaPassword])->find();
          if(!empty($result))
          {
              return ['result'=>'success'];
          }
          else
          {
             return['result'=>'failed'];
          }
      }

  }
