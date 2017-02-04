<?php
/**
 * Created by PhpStorm.
 * User: skateboard
 * Date: 2017/1/31
 * Time: 上午11:17
 */
namespace imserver\api;
class TestManager
{

    public function showMethod()
    {
        $rongManager=new RongManager();
        echo "This is test method";
    }
}

?>