<?php

namespace app\models;

use app\models\Model;

class Roles extends Model
{
    protected $table = 'roles';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
            'a.id',
            'a.role_name', 
        ]
        return "SELECT " . implode(', ', $fields) . " FROM $this->table a";
    }

    public function getAllRoles(): array
    {
        $query = $this->buildBaseQuery();
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}