<?php
 namespace app\CallSports\model;

 use think\Model;

 class TestModel extends Model
 {

     protected $table='ww_friendsinfo';

     public function updateNew()
     {
         $result = self::where('state', 1)->find();

         $result->save(['state' => 2]);
     }

     public function searchAndUpdate()
     {
         $result=self::where('state',1)->find();
         $result->save(['state'=>2]);
     }

 }