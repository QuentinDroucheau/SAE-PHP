<?php 

namespace models\db;

use PDO;
use PDOStatement;

class Database{

    private ?PDO $db;

    private static $instance = null;

    private function __construct(){
        $this->db = new PDO('sqlite:db/database.sqlite3');
        $this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    }

    public function __destruct(){
        $this->db = null;
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
     * @return Database
     */
    public static function getInstance(): self{
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    /**
     * @param string|null $name
     * @return string|false
     */
    public function lastInsertId(string|null $name = null): string|false{
        return $this->db->lastInsertId();
    }
}