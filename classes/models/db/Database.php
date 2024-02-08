<?php 

namespace models\db;

use PDO;
use PDOStatement;

class Database{

    private PDO $db;

    private static $instance = null;

    private function __construct(){
        $this->db = new PDO('sqlite:db/database.sqlite3');
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    /**
     * @param string $query
     * @return ?PDOStatement
     */
    public function query(string $query): ?PDOStatement{
        return $this->db->query($query);
    }

    /**
     * @param string $query
     * @return ?PDOStatement
     */ 
    public function prepare(string $query): ?PDOStatement{
        return $this->db->prepare($query);
    }

    /**
     * @return void
     */
    public function close(): void{
        $this->db = null;
    }

    /**
     * @return Database
     */
    public static function getInstance(): self{
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function lastInsertId(){
        return $this->db->lastInsertId();
    }
}