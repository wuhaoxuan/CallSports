<?php
namespace app\CallSports\controller;
use app\CallSports\model\ActivityModel;

class ActivityService
{

    public function publish($user_id,$name,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce)
    {
        $activityModel=new ActivityModel();
        $result=$activityModel->publish($user_id,$name,$time,$address,$latitude,$longitude,$total_num,$cost,$introduce);
        return $result;
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