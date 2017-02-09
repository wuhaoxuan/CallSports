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
          $alluserTableName=\Constant::ALL_USERS_TABLE;
          $activitySuffix=\Constant::ACTIVITY_SUFFIX;
          $createAllUsersTable="create table if NOT EXISTS  $alluserTableName (user_id varchar(30)  not null primary key,password varchar(40) not null,nick_name varchar(30) not null,email  varchar(60)  not null,sex varchar(5) not null,
                                          phone_num varchar(11) not null,protrait text  not null,reg_date TIMESTAMP)";
          Db::execute($createAllUsersTable);


//          $createFriendInfoTable="create table if NOT EXISTS $user_id"."$friendsSuffix (id int not null primary key auto_increment,user_id varchar(30) not null,nick_name varchar(30),email varchar(60),protrait text  not null,state int,
//                                          message text)";
//          Db::execute($createFriendInfoTable);

          $createActivityTable="create table if NOT EXISTS $user_id"."$activitySuffix (id int not null primary key AUTO_INCREMENT,uuid text not null,name text,type  int,members text,now_num int,INDEX(uuid))";
          Db::execute($createActivityTable);

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
//          $databaseName=\Constant::DATABASE_NAME;
//          $isTableExists="SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = \"$databaseName\" AND table_name = \"$this->table\"";
//          if(count($isTableExists)>0)
//          {
              $shaPassword = sha1($password);

              $result=self::where(['user_id'=>$userId])->find();
              if(empty($result))
              {
                  return ['result'=>\Constant::USER_NOT_EXISTS];
              }

              $result = self::where(['user_id' => $userId, 'password' => $shaPassword])->find();
              if (!empty($result))
              {
                  return ['result' => 'success', 'accontinfo' => $result];
              } else
              {
                  return ['result' => \Constant::LOGIN_FAILED];
              }
//          }
//          else
//          {
//              return ['result'=>\Constant::USER_NOT_EXISTS];
//          }
      }

  }
