<?php
  namespace app\callsports\controller;
  use app\callsports\model\AccountModel;
  use think\Db;
  use think\Request;

  class AccountService
  {
      protected $request;

      public function __construct()
      {
          $this->request=Request::instance();
      }

      public function register()
      {
          $user_id=$this->request->post('user_id');
          $password=$this->request->post('password');
          $nick_name=$this->request->post('nick_name');
          $email=$this->request->post('email');
          $sex=$this->request->post('sex');
          $phone_num=$this->request->post('phone_num');
          $head_protrait=$this->request->post('head_protrait');
          $accountModel=new AccountModel();
          $registerResult=$accountModel->registerNew($user_id,$password,$nick_name,$email,$sex,$phone_num,$head_protrait);
          return $registerResult;
      }

      public function login($user_id,$password)
      {

          $databaseName=\Constant::DATABASE_NAME;
          $tableName=\Constant::ALL_USERS_TABLE;
          $isTableExists="SELECT * FROM information_schema.tables WHERE table_schema = \"$databaseName\" AND table_name = \"$tableName\"";
          $result=Db::execute($isTableExists);
//          echo $isTableExists."\n";
//          echo $result;
          if($result>0)
          {
//              echo "big 0";
              $accountModel=new AccountModel();
              $loginResult=$accountModel->login($user_id,$password);
              return $loginResult;
          }
          else
          {
              return ['result'=>\Constant::USER_NOT_EXISTS];
          }
      }

      public function loginByToken($token)
      {
          $databaseName=\Constant::DATABASE_NAME;
          $tableName=\Constant::ALL_USERS_TABLE;
          $isTableExists="SELECT * FROM information_schema.tables WHERE table_schema = \"$databaseName\" AND table_name = \"$tableName\"";
          $result=Db::execute($isTableExists);
          if($result>0)
          {
              $accountModel=new AccountModel();
              $loginResult=$accountModel->loginByToken($token);
              return $loginResult;
          }
          else
          {
              return ['result'=>\Constant::USER_NOT_EXISTS];
          }
      }


      public function test()
      {
          return \Constant::SUCCESS;
      }

      public function uploadPortrait($userId)
      {

           $file=request()->file($userId);
           $result=\Constant::FAILED;
           if(!empty($file))
           {
               $newFile = $file->move(ROOT_PATH . 'public' . DS . 'portrait' . DS . "$userId");
               $newPath=ROOT_PATH . 'public' . DS . 'portrait' . DS . "$userId" . DS . "portrait.png";
               $url="http://".gethostbyname("localhost").DS.'public' . DS . 'portrait' . DS . "$userId" . DS . "portrait.png";
               if(rename($newFile->getPathname(),$newPath))
               {
                   rmdir($newFile->getPath());
                   $accountModel=new AccountModel();
                   $result=$accountModel->uploadPortrait($userId,$url);
                   if(count($result)>0)
                   {
                       $result=\Constant::SUCCESS;
                   }
               }

           }
           echo $result;
      }


  }