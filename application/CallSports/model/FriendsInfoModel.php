<?php
namespace app\callsports\model;

use think\Db;


class FriendsInfoModel
{
    protected $table;

    public function __construct($tableName=null)
    {
        $this->table = $tableName."_friendsinfo";
    }


    public function getFriendsInfo()
    {

        $result = Db::query("select * from $this->table");
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
//          $isExists=Db::execute("show tables like \"$requestUserId"."_friendsinfo");
        $insertData=['user_id'=>$requestUserId,'state'=>2,'message'=>$message];
        $userResult=Db::table($userId."_friendsinfo")->insert($insertData);
        $insertData=['user_id'=>$userId,'state'=>3,'message'=>$message];
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
          $result=Db::table($tableName)->where('user_id',$requestUserId)->find();
          return $result;

    }

}
