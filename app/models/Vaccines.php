<?php

namespace app\models;

use app\models\Model;

class Vaccines extends Model
{
    protected $table = 'vaccines';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'v.id',
            'v.name',
            'v.manufacturer',
            'v.doses_required',
            'v.recommended_age',
            'v.created_at',
            'v.updated_at',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table v";
    }

    public function getAllVaccines()
    {
        $sql = $this->buildBaseQuery();
        $this->db->query($sql);
        return $this->db->resultSet();
    }
}