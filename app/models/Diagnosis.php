<?php

namespace app\models;

use app\models\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnosis';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeJoins = false): string
    {
        $fields = [
            'd.id',
            'd.patient_id',
            'd.diagnosis',
            'd.dianosed_at',
            'notes',
        ];

        $query = "SELECT " . implode(', ', $fields) . " FROM {$this->table} p";
        return $query;
    }
}