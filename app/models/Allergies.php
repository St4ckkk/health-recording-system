<?php

namespace app\models;

use app\models\Model;

class Allergies extends Model
{
    protected $table = 'allergies';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeJoins = false): string
    {
        $fields = [
            'a.id',
            'a.patient_id',
            'a.allergy_type',
            'a.allery_name',
            'a.severity',
            'a.reaction',
            'a.recorded_at',
            'a.notes',
        ];

        $query = "SELECT " . implode(', ', $fields) . " FROM {$this->table} p";
        return $query;
    }
}