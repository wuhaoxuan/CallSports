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
          $user_id=$this->request->post('user_id');
          $password=$this->request->post('password');
          $nick_name=$this->request->post('nick_name');
          $email=$this->request->post('emial');
          $sex=$this->request->post('sex');
          $phone_num=$this->request->post('phone_num');
          $head_protrait=$this->request->post('head_protrait');
          $accountModel=new AccountModel();
          $registerResult=$accountModel->registerNew($user_id,$password,$nick_name,$email,$sex,$phone_num,$head_protrait);
          return $registerResult;
      }

      public function login($user_id,$password)
      {

          $accountModel=new AccountModel();
          $loginResult=$accountModel->login($user_id,$password);
          return $loginResult;
      }
  }