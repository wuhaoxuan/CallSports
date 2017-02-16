<?php
namespace app\CallSports\controller;
use app\CallSports\model\ActivityModel;
use think\Db;

class ActivityService
{

    private $activityModel;

    public function __construct()
    {
        $this->activityModel=new ActivityModel();
    }

    public function publish($user_id,$nickName,$name,$sporttype,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce)
    {
        $this->createAllActivitiesTable();
//        $activityModel=new ActivityModel();
        $result=$this->activityModel->publish($user_id,$nickName,$name,$sporttype,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce);
        return $result;
    }


    private function createAllActivitiesTable()
    {
        $createBtn="CREATE TABLE IF NOT EXISTS all_activities(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,user_id VARCHAR(30),nick_name VARCHAR(30),uuid TEXT,name TEXT,sporttype TEXT,time VARCHAR(30),address TEXT,latitude DOUBLE,longitude DOUBLE,total_num INT ,now_num INT,cost VARCHAR(10),introduce TEXT,INDEX(uuid(36)))";
        Db::execute($createBtn);
    }

    public function joinAct($creater_id,$user_id,$uuid)
    {
        $result=$this->activityModel->joinAct($creater_id,$user_id,$uuid);
        return $result;
    }


    public function getAllActInfo($start,$offset)
    {
        $this->createAllActivitiesTable();
//        $actModel=new ActivityModel();
        $result=$this->activityModel->getAllActInfo($start,$offset);
        return $result;

    }

    public function test($creater_id,$user_id,$uuid)
    {
        $item=Db::table($creater_id.\Constant::ACTIVITY_SUFFIX)->where('uuid',$uuid)->find();
        return $item;
    }

//    public function test()
//    {
//        $activityModel=new ActivityModel();
//        $activityModel->test();
//    }

}