<?php 

try{
    $sql = file_get_contents("bd/table.sql");
    $db = new \PDO("sqlite:bd/database.sqlite3");
    $db->exec($sql);
    $db = null;
}catch(\Exception $e){
    echo $e->getMessage();
}