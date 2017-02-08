<?php
  namespace app\callsports\controller;
  use imserver\api\RongManager;

  class GroupService
  {

      private $rongManager;

      public function __construct()
      {
          $this->rongManager=new RongManager();
      }

      public function createGroup($userId,$groupName)
      {
          $userId=array($userId);
          $groupId="99";
          $this->rongManager->createGroup($userId,$groupId,$groupName);
          $this->rongManager->joinGroup($userId,$groupId,$groupName);
          $message="你创建了".$groupName."群。";
//          echo "use id is $userId";
          $this->rongManager->publicGroupMessage($userId,$groupId,$message,$message,$message);
      }

      public function syncGroup($userId)
      {
          $groupInfo=array('99');
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

  }
