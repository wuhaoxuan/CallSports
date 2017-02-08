<?php
  namespace app\callsports\controller;
  use imserver\api\RongManager;
  use think\Db;

  class GroupService
  {

      private $rongManager;

      public function __construct()
      {
          $this->rongManager=new RongManager();
      }

      public function createGroup($userId,$groupId,$groupName)
      {
          $this->rongManager->createGroup($userId,$groupId,$groupName);
          $message="你创建了".$groupName."群。";
//          echo "use id is $userId";
          $result=$this->rongManager->publicGroupMessage($userId,$groupId,'RC:InfoNtf',$message,$message,$message);
          return $result;
      }

      public function joinGroup($userId,$groupId,$groupName)
      {
          $result=$this->rongManager->joinGroup($userId,$groupId,$groupName);
          return $result;
      }

      public function syncGroup($userId,$groupInfo)
      {

          $this->rongManager->syncGroup($userId,$groupInfo);
      }


      public function getGroupInfo($groupId)
      {

      }

      public function publicGroupMessage($userId,$groupId,$message,$pushMessage='',$pushData='',$extra='')
      {
          $groupId=array($groupId);
          $this->rongManager->publicGroupMessage($userId,$groupId,$message,$pushMessage,$pushData,$extra);
      }

      public function refresh($groupId, $groupName)
      {
          $this->rongManager->refreshGroup($groupId,$groupName);
      }


      public function test($userId)
      {

          $allTableName=\Constant::ALL_ACTIVITIES_TABLE;
          $sql="SELECT * FROM all_users WHERE user_id='f'";
          $result=Db::query($sql);
          if(count($result)>0)
          {
              echo "not empty";
          }
          else
          {
              echo "empty";
          }
//          echo $result[0]['user_id'];
          return $result;
      }
  }
