<?php
// Include the config file to access database constants
require_once dirname(__DIR__) . '/config/config.php';

class Database
{
    private static $instance = null;
    private $connection;
    private $stmt;

    private function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Add query method
    public function query($sql)
    {
        $this->stmt = $this->connection->prepare($sql);
    }

    // Add bind method
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    // Add execute method
    public function execute()
    {
        return $this->stmt->execute();
    }

    // Add resultSet method
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Add single method
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Add rowCount method
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    // Add lastInsertId method
    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }
}