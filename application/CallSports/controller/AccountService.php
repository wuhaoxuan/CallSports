<?php
  namespace app\callsports\controller;
  use app\callsports\model\AccountModel;
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
          $user_id=$this->request->get('user_id');
          $password=$this->request->get('password');
          $nick_name=$this->request->get('nick_name');
          $email=$this->request->get('emial');
          $sex=$this->request->get('sex');
          $phone_num=$this->request->get('phone_num');
          $head_protrait=$this->request->get('head_protrait');
          $accountModel=new AccountModel();
          $registerResult=$accountModel->registerNew($user_id,$password,$nick_name,$email,$sex,$phone_num,$head_protrait);
          return $registerResult;
      }

      public function login()
      {
          $user_id=$this->request->get('user_id');
          $password=$this->request->get('password');
          $accountModel=new AccountModel();
          $loginResult=$accountModel->login($user_id,$password);
          return $loginResult;
      }
  }