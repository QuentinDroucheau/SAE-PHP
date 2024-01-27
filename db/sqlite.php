<?php 

try{
    $sql = file_get_contents("db/table.sql");
    $db = new \PDO("sqlite:db/database.sqlite3");
    $db->exec($sql);
    $db = null;
}catch(\Exception $e){
    echo $e->getMessage();
}