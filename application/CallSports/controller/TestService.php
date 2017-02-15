<?php
  namespace app\callsports\controller;

  use app\CallSports\model\TestModel;
  use imserver\api\TestManager;
  use think\Db;
  use think\Exception;

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

     public function test($par1,$par2)
     {

         $this->timeStamp($par2);
//         Db::startTrans();
//         try
//         {
//             $result=Db::table("test")->lock(true)->where("dd",2)->find();
//             if($result!=null)
//             {
//                 Db::table("test")->insert(['dd'=>1000]);
//             }
////             $sql = "INSERT INTO test (dd) VALUES (136)";
////             $querySql="SELECT * FROM test FOR UPDATE";
////             Db::execute($querySql);
////             Db::execute($sql);
//             echo "insert success";
//             sleep(10);
//             Db::commit();
//         }
//         catch(Exception $e)
//         {
//             echo "error";
//             Db::rollback();
//         }
         phpinfo();

     }

      public function test2()
      {


          Db::startTrans();
          try
          {
              $result=Db::table("test")->lock(true)->where("dd",2)->find();
              if($result!=null)
              {

                  Db::table("test")->insert(['dd'=>1002]);
              }
//             $sql = "INSERT INTO test (dd) VALUES (136)";
//             $querySql="SELECT * FROM test FOR UPDATE";
//             Db::execute($querySql);
//             Db::execute($sql);
              echo "insert success";
//              sleep(10);
              Db::commit();
          }
          catch(Exception $e)
          {
              echo "error";
              Db::rollback();
          }

      }

      public function timeStamp($par='',$par2)
      {

          $data=time();
          $med=md5("d"."111111".$data);
          echo $med;
      }

      public function ipTest()
      {
//          $hostname=gethostbyaddr($_SERVER['remote_addr']);    //获取主机名
//          echo $hostname;            //输出结果
//
          $hosts=\CommonHelper::getSportTypePortraitUrl("fff");    //获取ip地址列表
          print_r($hosts);
      }

  }