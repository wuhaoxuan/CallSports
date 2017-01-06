<?php
  namespace app\callsports\controller;

  use app\CallSports\model\TestModel;

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

  }