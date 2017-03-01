<?php
namespace app\CallSports\model;


use imserver\api\RongManager;
use think\Db;
use think\Exception;
use think\Model;


class ActivityModel extends Model
{
    protected $table = \Constant::ALL_ACTIVITIES_TABLE;

    private $rongManager;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->rongManager=new RongManager();
    }

    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        $this->rongManager=new RongManager();
    }

    public function publish($user_id, $nickName,$name,$sporttype, $time, $address, $latitude, $longitude, $total_num, $cost, $introduce)
    {
        $uuid = $this->create_uuid();
        $insertData = ['user_id' => $user_id, 'nick_name'=>$nickName,'uuid' => $uuid, 'name' => $name, 'sporttype'=>$sporttype,'time' => $time, 'address' => $address, 'latitude' => $latitude, 'longitude' => $longitude, 'total_num' => $total_num, 'cost' => $cost, 'introduce' => $introduce, 'now_num' => 1,'members'=>$user_id];
        $this->data($insertData);
        $allInsertResult = $this->save();
        if (empty($allInsertResult))
        {
            return ['result' => \Constant::FAILED];
        } else
        {

            $insertData = ['uuid' => $uuid, 'name' => $name, 'sporttype'=>$sporttype,'type' => \Constant::ACTIVITY_CREATE, 'members' => $user_id,'now_num' => 1,'state'=>\Constant::STATE_JOINED];
            $sigInsertResult = Db::table($user_id . "_activity")->insert($insertData);
            if ($sigInsertResult)
            {
                $this->rongManager->createGroup($user_id,$uuid,$name);
                $this->rongManager->publicGroupMessage(\Constant::SYSTEM_USER,$uuid,"RC:GrpNtf","群已经建立","群已经建立","");
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
                $query=Db::table($creater_id.\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid);
                $item=$query->find();
                $members = $item['members'];
                if ($this->containUserId($user_id, $members))
                {
                    return ['result' => \Constant::HAS_JOINED];
                }
                self::where('uuid',$uuid)->update(['now_num'=>$item['now_num']+1,'members'=>$members.",$user_id"]);
                $data = ['now_num'=>$item['now_num']+1,'members' => $members . ",$user_id"];
                $result=Db::table($creater_id.\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid)->update($data);

                if (empty($result))
                {
                    Db::commit();
                    return ['result' => \Constant::FAILED];
                } else
                {
                    $item['members']=$item['members'].",$user_id";
                    $item['now_num']=$item['now_num']+1;
                    Db::table($user_id.\Constant::ACTIVITY_SUFFIX)->insert($item);
                    $this->rongManager->joinGroup($user_id,$uuid,$item['name']);
                    $this->rongManager->publicGroupMessage(\Constant::SYSTEM_USER,$uuid,"RC:GrpNtf","$user_id 加入","$user_id 加入","");
                    Db::commit();
                    return ['result' => \Constant::SUCCESS];
//                    $result = Db::table($creater_id . "_activity")->lock(true)->where('uuid', $uuid)->update(['members' => $members . ",$user_id"]);
//                    if ($result)
//                    {
//                        return ['result' => \Constant::SUCCESS];
//                    } else
//                    {
//                        return ['result' => \Constant::FAILED];
//                    }
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
//        if(empty($result))
//        {
//            $result=['result'=>\Constant::FAILED,'acts'=>$result];
//        }
//        else
//        {
            $result=['result'=>\Constant::SUCCESS,'acts'=>$result];
//        }
        return $result;
    }

    public function cancelAct($userId,$uuid)
    {
        Db::startTrans();
        try
        {
            $result=['result'=>\Constant::SUCCESS];
            $allResult = self::where('uuid', $uuid)->delete();
            if (count($allResult) > 0)
            {
                $item=Db::table($userId.\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid)->find();
                $members=$item['members'];
                $groupId=$item['uuid'];
                for($index=0;$index<count($members);$index++)
                {
                    $echResult=Db::table($members[$index].\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid)->update(['state'=>\Constant::STATE_DISMISS]);
                }
                $this->rongManager->dismissGroup($userId,$groupId);
                $message="活动已取消，该群聊已解散。";
                $this->rongManager->publicGroupMessage($userId,$groupId,"RC:GrpNtf",$message,$message,'');
                $result['result']=\Constant::SUCCESS;

            }
            else
            {
                $result['result']=\Constant::NOT_EXISTS;
            }
            Db::commit();
            return $result;
        }
        catch (Exception $e)
        {
            $result['result']=\Constant::FAILED;
            Db::rollback();
            return $result;
        }
    }

    public function quitAct($userId,$uuid)
    {
        Db::startTrans();
        try
        {
            $result=['result'=>\Constant::SUCCESS];
            $item=self::where('uuid',$uuid)->find();
            $item['members']=str_repeat(",$userId","",$item['members']);
            self::where('uuid',$uuid)->update($item);
            Db::table($userId.\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid)->update(['state'=>\Constant::STATE_QUIT]);
            $this->rongManager->quitGroup($userId,$uuid);
            return $result;
        }
        catch(Exception $e)
        {
            Db::rollback();
            $result=['result'=>\Constant::FAILED];
            return $result;
        }
    }

    public function test($userId,$uuid)
    {
//        $model=new ActivityModel();
//        $result=$model->where('id','>',0)->limit(1)->find();
//        if(empty($result))
//        {
//            $result=['result'=>\Constant::FAILED];
//        }
//        else
//        {
//           $result=['result'=>\Constant::SUCCESS,'acts'=>$result];
//        }
//        echo $result;
        Db::startTrans();
        try
        {
            $result=['result'=>\Constant::SUCCESS];
            $allResult = self::where('uuid', $uuid)->delete();
            if (count($allResult) > 0)
            {
                $members=Db::table($userId.\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid)->find();
                for($index=0;$index<count($members);$index++)
                {
                    $echResult=Db::table($members[$index].\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid)->delete();
                }

//               if($echResult>0)
//               {
                   $result['result']=\Constant::SUCCESS;
//               }
//               else
//               {

//               }

            }
            else
            {
                  $result['result']=\Constant::NOT_EXISTS;
            }
            Db::commit();
        }
        catch (Exception $e)
        {
            $result['result']=\Constant::FAILED;
            Db::rollback();
        }
    }
}