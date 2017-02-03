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

        $result = Db::query("select * from $userId"."_friendsinfo");
        $result = array("friendsinfo" => $result);
        return $result;
    }


    public function modifyFriendState($userId, $requestUserId, $accept)
    {
        $isExists=Db::execute("show tables like \"$requestUserId"."_friendsinfo\"");
        if ($accept)
        {
            Db::table($this->tableName)->where('user_id', $requestUserId)->update(['state' => 1]);
            if($isExists)
            {
                Db::table($requestUserId . "_friendsinfo")->where('user_id', $userId)->update(['state' => 1]);
            }
            return ['result'=>'accept'];
        }

         else
         {
             Db::table($this->tableName)->where('user_id', $requestUserId)->update(['state' => 5]);
             if($isExists)
             {
                 Db::table($requestUserId . "_friendsinfo")->where('user_id', $userId)->update(['state' => 4]);
             }
             return ['result'=>'deny'];
         }
    }


    public function requestFriend($userId,$requestUserId,$message)
    {
        //insert data in user
        $email=Db::table('all_users')->where('user_id',$requestUserId)->value('email');
        $protrait=Db::table('all_users')->where('user_id',$requestUserId)->value('protrait');
        $insertData=['user_id'=>$requestUserId,'state'=>2,'message'=>$message,'email'=>$email,'protrait'=>$protrait];
        $userResult=Db::table($userId."_friendsinfo")->insert($insertData);

        //insert data in requestUser
        $email=Db::table('all_users')->where('user_id',$userId)->value('email');
        $protrait=Db::table('all_users')->where('user_id',$userId)->value('protrait');
        $insertData=['user_id'=>$userId,'state'=>3,'message'=>$message,'email'=>$email,'protrait'=>$protrait];
        $requestUserResult=Db::table($requestUserId.'_friendsinfo')->insert($insertData);
        if($userResult && $requestUserResult)
        {
            return ["result"=>"success"];
        }
        else
        {
            return ['result'=>'failed'];
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

    public function getUserInfo($useId)
    {
        $tableName=\Constant::ALL_USERS_TABLENAME;
        $result=Db::table($tableName)->where('user_id',$useId)->find();
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
