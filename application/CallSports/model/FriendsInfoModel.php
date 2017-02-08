<?php
namespace app\callsports\model;

use think\Db;


class FriendsInfoModel
{
//    protected $table;
//
//    public function __construct($tableName=null)
//    {
//        $this->table = $tableName."_friendsinfo";
//    }

    public function getFriendsInfo($userId)
    {

        $result=Db::table($userId.\Constant::FRIENDS_SUFFIX)->find();
//        $result = Db::query("select * from $userId"."_friendsinfo");
        if($result!=null)
        {
            $result = array("friendsinfo" => array($result));
        }
        else
        {
            $result = array("friendsinfo" =>$result);
        }
        return $result;
    }


    public function modifyFriendState($userId, $requestUserId, $accept)
    {
        $isExists=Db::execute("show tables like \"$requestUserId"."_friendsinfo\"");
        $fromTable=$userId.\Constant::FRIENDS_SUFFIX;
        $toTable=$requestUserId.\Constant::FRIENDS_SUFFIX;
        if ($accept)
        {

            Db::table($fromTable)->where('user_id', $requestUserId)->update(['state' => \Constant::FRIEND_STATE_FRIEND]);
            if($isExists)
            {
                Db::table($toTable)->where('user_id', $userId)->update(['state' => \Constant::FRIEND_STATE_FRIEND]);
            }
            return ['result'=>\Constant::FRIEND_STATE_FRIEND];
        }

         else
         {
             Db::table($fromTable)->where('user_id', $requestUserId)->update(['state' =>\Constant::FRIEND_STATE_REQUEST_DENYED]);
             if($isExists)
             {
                 Db::table($toTable)->where('user_id', $userId)->update(['state' =>\Constant::FRIEND_STATE_REQUEST_DENY]);
             }
             return ['result'=>\Constant::FRIEND_STATE_REQUEST_DENY];
         }
    }


    public function requestFriend($userId,$requestUserId,$message)
    {
        //insert data in user
        $dbHelper=new \DbHelper();
        $dbHelper->lockTable($userId.\Constant::FRIENDS_SUFFIX);
        $dbHelper->lockTable($requestUserId.\Constant::FRIENDS_SUFFIX);
        $state=Db::table($userId.\Constant::FRIENDS_SUFFIX)->where('user_id',$requestUserId)->value('state');
        if(\Constant::FRIEND_STATE_REQUEST==$state)
        {
            return ["result"=>\Constant::REQUEST_HAS_SENT];
        }
        else if(\Constant::FRIEND_STATE_FRIEND==$state)
        {
            return ['result'=>\Constant::ALREADY_FRIEND];
        }
        $email=Db::table('all_users')->where('user_id',$requestUserId)->value('email');
        $protrait=Db::table('all_users')->where('user_id',$requestUserId)->value('protrait');
        $nickName=Db::table('all_users')->where('user_id',$requestUserId)->value('nick_name');
        $insertData=['nick_name'=>$nickName,'user_id'=>$requestUserId,'state'=>\Constant::FRIEND_STATE_REQUEST,'message'=>$message,'email'=>$email,'protrait'=>$protrait];
        $userResult=Db::table($userId.\Constant::FRIENDS_SUFFIX)->insert($insertData);

        //insert data in requestUser
        $email=Db::table('all_users')->where('user_id',$userId)->value('email');
        $protrait=Db::table('all_users')->where('user_id',$userId)->value('protrait');
        $nickName=Db::table('all_users')->where('user_id',$userId)->value('nick_name');
        $insertData=['nick_name'=>$nickName,'user_id'=>$userId,'state'=>\Constant::FRIEND_STATE_REQUESTED,'message'=>$message,'email'=>$email,'protrait'=>$protrait];
        $requestUserResult=Db::table($requestUserId.\Constant::FRIENDS_SUFFIX)->insert($insertData);
        $dbHelper->unlockTable();
        if($userResult && $requestUserResult)
        {
            return ["result"=>\Constant::SUCCESS];
        }
        else
        {
            return ['result'=>\Constant::FAILED];
        }
    }

    public function searchFriend($requestUserId)
    {
          $tableName="all_users";
          $result=Db::query("select user_id,nick_name,email,sex,phone_num,protrait from $tableName where user_id=?",[$requestUserId]);
//          $result=Db::table($tableName)->where('user_id',$requestUserId)->column(['user_id','nick_name','email','sex','phone_num','protrait']);
         if(count($result)>0)
         {
             $result[0]['result']='found';
         }
         return $result[0];

    }

    public function getUserInfo($userId)
    {
        $tableName=\Constant::ALL_USERS_TABLENAME;
        $result=Db::table($tableName)->where('user_id',$userId)->find();
        if(!empty($result))
        {
            return ['result'=>'success','accontinfo'=>$result];
        }
        else
        {
            return['result'=>'failed'];
        }
    }

}
