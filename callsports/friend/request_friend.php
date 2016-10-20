<?php
 use \callsports\library\SQLManager;
 require("../library/SQLManager.php");
 $userId=$_POST["userId"];
 $sqlManager=new SQLManager($userId);

?>