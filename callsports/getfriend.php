<?php
 use \callsports\library\SQLManager;
 require("./library/SQLManager.php");
 $userId=$_POST['userId'];
 $serverName="localhost";
 $userName="root";
 $passWord="132231";
 $dbName="CallSports";
 $tableName="user_".$userId;
 $sqlManager=new SQLManager($serverName,$userName,$passWord,$dbName,$tableName);
 $result=$sqlManager->queryData(array("*"),null);
 $result=json_encode($result);
 $result="{friendinfo:'$result'}";
 echo $result;
?>