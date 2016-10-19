<?php

function db_connect() {
   $result = new mysqli('localhost', 'user','passwd', 'userInfo');
   if (!$result) {
     throw new Exception('Could not connect to database server');
   } else {
     return $result;
   }
}

?>
