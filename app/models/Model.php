<?php

namespace app\models;

class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        require_once dirname(__DIR__) . '/core/Database.php';
        $this->db = \Database::getInstance();
    }

    public function getAll($conditions = [])
    {
        $sql = "SELECT * FROM {$this->table}";

        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $parts = [];

            foreach ($conditions as $key => $value) {
                $parts[] = "$key = :$key";
            }

            $sql .= implode(' AND ', $parts);
        }

        $this->db->query($sql);

        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $this->db->bind(":$key", $value);
            }
        }

        return $this->db->resultSet();
    }

    public function getById($id)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getByField($field, $value)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE $field = :value");
        $this->db->bind(':value', $value);
        return $this->db->resultSet();
    }

    public function getSingleByField($field, $value)
    {
        $this->db->query("SELECT * FROM {$this->table} WHERE $field = :value");
        $this->db->bind(':value', $value);
        return $this->db->single();
    }
}