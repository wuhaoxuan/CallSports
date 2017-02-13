<?php
namespace app\CallSports\model;


use think\Db;
use think\Exception;
use think\Model;


class ActivityModel extends Model
{
    protected $table = \Constant::ALL_ACTIVITIES_TABLE;


    public function publish($user_id, $nickName,$name, $time, $address, $latitude, $longitude, $total_num, $cost, $introduce)
    {
        $uuid = $this->create_uuid();
        $insertData = ['user_id' => $user_id, 'nick_name'=>$nickName,'uuid' => $uuid, 'name' => $name, 'time' => $time, 'address' => $address, 'latitude' => $latitude, 'longitude' => $longitude, 'total_num' => $total_num, 'cost' => $cost, 'introduce' => $introduce, 'now_num' => 1];
        $this->data($insertData);
        $allInsertResult = $this->save();
        if (empty($allInsertResult))
        {
            return ['result' => \Constant::FAILED];
        } else
        {

            $insertData = ['uuid' => $uuid, 'name' => $name, 'type' => \Constant::ACTIVITY_CREATE, 'members' => $user_id];
            $sigInsertResult = Db::table($user_id . "_activity")->insert($insertData);
            if ($sigInsertResult)
            {
                return ['result' => \Constant::SUCCESS,'uuid'=>$uuid];
            } else
            {
                return ['result' => \Constant::FAILED];
            }
        }

    }

    public function joinAct($creater_id, $user_id, $uuid)
    {
        Db::startTrans();
        try
        {
            $item = self::where('uuid', $uuid)->lock(true)->find();
            if (empty($item))
            {
                return ['result' => \Constant::NOT_EXISTS];
            } else
            {
                $members = $item->getAttr('members');
                if ($this->containUserId($user_id, $members))
                {
                    return ['result' => \Constant::HAS_JOINED];
                }
                $data = ['members' => $item->getAttr('members') . ",$user_id"];
                $result = $item->save($data);
                if (empty($result))
                {
                    return ['result' => \Constant::FAILED];
                } else
                {
                    $result = Db::table($creater_id . "_activity")->lock(true)->where('uuid', $uuid)->update(['members' => $members . ",$user_id" . ":" . \Constant::ACTIVITY_APPLYING]);
                    if ($result)
                    {
                        return ['result' => \Constant::SUCCESS];
                    } else
                    {
                        return ['result' => \Constant::FAILED];
                    }
                }
            }
        }
        catch(Exception $e)
        {
            Db::rollback();
            return ['result' => \Constant::FAILED];
        }
    }

    private function create_uuid($prefix = "")
    {    //可以指定前缀
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8) . '-';
        $uuid .= substr($str, 8, 4) . '-';
        $uuid .= substr($str, 12, 4) . '-';
        $uuid .= substr($str, 16, 4) . '-';
        $uuid .= substr($str, 20, 12);
        return $prefix . $uuid;
    }

    public function containUserId($userId, $text)
    {
        $pattern = "/\\b$userId\\b/";
        $result = preg_match($pattern, $text);
        return $result;
    }

    public function getAllActInfo($start,$offset)
    {
        $result=self::where('id','>=',$start)->limit($offset)->select();
        return $result;
    }

    public function test()
    {
        $model=new ActivityModel();
        $result=$model->where('id','>',0)->limit(1)->find();
        echo $result;
    }
}