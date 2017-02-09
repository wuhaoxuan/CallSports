<?php
namespace app\CallSports\controller;
use app\CallSports\model\ActivityModel;
use think\Db;

class ActivityService
{

    public function publish($user_id,$nickName,$name,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce)
    {
        $this->createAllActivitiesTable();
        $activityModel=new ActivityModel();
        $result=$activityModel->publish($user_id,$nickName,$name,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce);
        return $result;
    }


    private function createAllActivitiesTable()
    {
        $createBtn="CREATE TABLE IF NOT EXISTS all_activities(user_id VARCHAR(30),nick_name VARCHAR(30),uuid TEXT,name TEXT,time VARCHAR(30),address TEXT,latitude DOUBLE,longitude DOUBLE,total_num INT ,now_num INT,cost VARCHAR(10),introduce TEXT,INDEX(uuid))";
        Db::execute($createBtn);
    }

    public function joinAct($creater_id,$user_id,$uuid)
    {
        $activityModel=new ActivityModel();
        $result=$activityModel->joinAct($creater_id,$user_id,$uuid);
        return $result;
    }



    public function test()
    {
        $activityModel=new ActivityModel();
        $activityModel->test();
    }

}