<?php
   namespace callsports\library;
   class SQLManager
   {
      private $serverName="localhost";
      private $userName="root";
      private $passWord="132231";
      private $dbName;
      private $tableName;
      private $conn;
      private static $sqlManager;
      
      public function __construct($serverName,$userName,$passWord,$dbName,$tableName)
      {
        try
        {
          $this->serverName=$serverName; 
          $this->dbName=$dbName;
          $this->tableName=$tableName;
          $this->userName=$userName;
          $this->passWord=$passWord;
          $this->conn=new \PDO("mysql:host=$this->serverName;dbname=$this->dbName",$this->userName,$this->passWord); 
          $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
          echo $e->getMessage();
        }
      }

      public function createDatabase()
      {
        $sql="create database $dbName";
        try
        {
          $this->conn->exec($sql);
          return true;
        }
        catch(PDOException $e)
        {
          return false;
        }
      }  

      public function createTable($colArray)
      {
          try
        {
          $colData=implode(",", $colArray);
          $sql="create table $this->tableName ($colData)";  
          $this->conn->exec($sql);
          return true;
        }
        catch(PDOException $e)
        {
         echo "create table this->$tableName failed" . $e->getMessage();
         return false;
        }

      }
     

     public function insertValue($columsArray,$insertDataArray)
     {

        try
        {
          $colums=implode(",", $columsArray);
          $datas=implode(",", $insertDataArray);
          $sql="insert into $this->tableName ($colums) values ($datas)";
          $this->conn->exec($sql);
          return true;
        }
        catch(PDOException $e)
        {
          return false;
        }

     }

     public function deleteData($condition)
     {
        try
        {
             if($condition==null)
             {
               $sql="delete from $this->tableName";
             } 
             else
             {
              $sql="delete from $this->tableName where $condition";
             }
             $this->conn->exec($sql);
             return true;
        }
        catch(PDOException $e)
        {
            return false;
        }
     }

     public function queryData($colArray,$condition)
     {
         try
         {
             $querySen=implode(",", $colArray);
             $sql="select $querySen from $this->tableName where $condition";
             $stmt= $this->conn->query($sql);
             $result=$stmt->setFetchMode(\PDO::FETCH_ASSOC);
             $result=$stmt->fetchAll();
             return $result;
         }

         catch(PDOException $e)
         {
             return null;
         }

     }


     public function updateValue($newValueArray,$condition)
     {
       try
       {
            $dataArray=implode("=", $newValueArray);
            $sql="update $this->tableName set $dataArray where $condition";
            $this->conn->exec($sql);
            return true;
       }

       catch(PDOException $e)
       {
           return false;
       }

     }

     public function deleteTable($tableName)
     {
        try
        {
           $sql="drop table $tableName";
           $this->conn->exec($sql);
           return true;
        }
        catch(PDOException $e)
        {
          return false;
        }

     }

     
   }


?>
