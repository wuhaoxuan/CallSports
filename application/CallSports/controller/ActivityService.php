<?php
namespace app\CallSports\controller;
use app\CallSports\model\ActivityModel;
use think\Db;

class ActivityService
{

    public function publish($user_id,$name,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce)
    {
        $this->createAllActivitiesTable();
        $activityModel=new ActivityModel();
        $result=$activityModel->publish($user_id,$name,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce);
        return $result;
    }


    private function createAllActivitiesTable()
    {
        $createBtn="create table IF NOT EXISTS all_activities(user_id VARCHAR(30),uuid TEXT,name TEXT,time VARCHAR(30),address TEXT,latitude DOUBLE,longitude DOUBLE,total_num INT ,cost VARCHAR(10),introduce TEXT,now_num INT,members TEXT)";
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