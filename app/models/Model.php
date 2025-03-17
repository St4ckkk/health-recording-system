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

    public function create($data)
    {
        // Extract column names and placeholders
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $this->db->query("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");

        // Bind all values
        foreach ($data as $key => $value) {
            $this->db->bind(":$key", $value);
        }

        // Execute and return the last insert ID if successful
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    public function update($id, $data)
    {
        // Build SET part of query
        $setParts = [];
        foreach (array_keys($data) as $key) {
            $setParts[] = "$key = :$key";
        }
        $setClause = implode(', ', $setParts);

        $this->db->query("UPDATE {$this->table} SET $setClause WHERE id = :id");

        // Bind all values
        foreach ($data as $key => $value) {
            $this->db->bind(":$key", $value);
        }
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function count($conditions = [])
    {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";

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

        $result = $this->db->single();
        return $result->count;
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