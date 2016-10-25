<?php
 include_once '../library/imserver/api/rongcloud.php';
 class RongManager
 {
   private $appKey = 'lmxuhwagxh61d';
   private $appSecret = 'MADzJImCROOxS2';
   private $jsonPath = "jsonsource/";
   private $rongCloud;
   public function __construct()
   {
      $this->rongCloud=new RongCloud($appKey,$appSecret);
   }

   public function publishPrivate($fromUserId, $toUserId,  $objectName, $content, $pushContent = '', $pushData = '', $count = '', $verifyBlacklist, $isPersisted, $isCounted)
   {
   	 $result=$this->rongCloud->message()->publishPrivate($fromUserId, $toUserId, '$objectName',$content, '$pushContent', '$pushData', $count,$verifyBlacklist,$isPersisted, $isCounted);
   	 print_r($result);
	echo "\n";
   }

   public function PublishSystem($fromUserId, $toUserId,  $objectName, $content, $pushContent = '', $pushData = '', $isPersisted, $isCounted) 
   {
   	 if($this->rongCloud==null)
   	 {
   	 	echo "null";
   	 }
   	 $result=$this->rongCloud->Message()->PublishSystem($fromUserId, $toUserId, '$objectName',$content, '$pushContent', '$pushData', $isPersisted, $isCounted);
     print_r($result);
	echo "\n";
   }


   echo ("\n***************** group **************\n");
	// 创建群组方法（创建群组，并将用户加入该群组，用户将可以收到该群的消息，同一用户最多可加入 500 个群，每个群最大至 3000 人，App 内的群组数量没有限制.注：其实本方法是加入群组方法 /group/join 的别名。）
   public function createGroup($userId, $groupId, $groupName)
   {
	$result = $this->rongCloud->group()->create($userId, $groupId, $groupName);
	print_r($result);
	echo "\n"; 
   }
	
	// 同步用户所属群组方法（当第一次连接融云服务器时，需要向融云服务器提交 userId 对应的用户当前所加入的所有群组，此接口主要为防止应用中用户群信息同融云已知的用户所属群信息不同步。）
   public function syncGroup($userId, $groupInfo)
   {
	
	$result = $this->rongCloud->group()->sync($userId, $groupInfo);
	print_r($result);
	echo "\n";
  }
	
	// 刷新群组信息方法
  public function refreshGroup($groupId, $groupName)
  {

	$result = $this->rongCloud->group()->refresh($groupId, $groupName);
	print_r($result);
	echo "\n";
   }
	// 将用户加入指定群组，用户将可以收到该群的消息，同一用户最多可加入 500 个群，每个群最大至 3000 人。
   public function joinGroup($userId, $groupId, $groupName)
  {	
  	$result = $this->rongCloud->group()->join($userId, $groupId, $groupName);
	print_r($result);
	echo "\n";
  }
	// 查询群成员方法
   public function queryGroupUser($groupId)
   {
	$result = $this->rongCloud->group()->queryUser($groupId);
	print_r($result);
	echo "\n";
   }
	// 退出群组方法（将用户从群中移除，不再接收该群组的消息.）
   public function quitGroup($userId, $groupId)
   {
	$result = $this->rongCloud->group()->quit($userId, $groupId);
	print_r($result);
	echo "\n";
   }
	// 添加禁言群成员方法（在 App 中如果不想让某一用户在群中发言时，可将此用户在群组中禁言，被禁言用户可以接收查看群组中用户聊天信息，但不能发送消息。）
   public function addGagUser($userId, $groupId, $minute)
   {
	$result = $this->rongCloud->group()->addGagUser($userId, $groupId, $minute);
	print_r($result);
	echo "\n";
   }
	// 查询被禁言群成员方法
   public function lisGagUser($groupId)
   {
	$result = $this->rongCloud->group()->lisGagUser($groupId);
	print_r($result);
	echo "\n";
  }
	
	// 移除禁言群成员方法
  public function rollBackGagUser($userId, $groupId)
  {
	$result = $RongCloud->group()->rollBackGagUser($userId, $groupId);
	print_r($result);
	echo "\n";
  }	
	// 解散群组方法。（将该群解散，所有用户都无法再接收该群的消息。）
  public function dismissGroup($userId, $groupId)
  {
	$result = $this->rongCloud->group()->dismiss($userId, $groupId);
	print_r($result);
	echo "\n";
 }

 }

?>