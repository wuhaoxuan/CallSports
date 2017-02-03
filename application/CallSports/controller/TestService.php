<?php
  namespace app\callsports\controller;

  use app\CallSports\model\TestModel;
  use imserver\api\TestManager;

  class TestService
  {
     public function updateNew()
     {
         $model=new TestModel();
         $model->updateNew();
     }

     public function searchAndUpdate()
     {
         $model=new TestModel();
         $model->searchAndUpdate();
     }

     public function showMethod()
     {
         $testManager=new TestManager();
         $testManager->showMethod();
     }

  }