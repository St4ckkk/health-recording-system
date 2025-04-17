<?php

namespace app\models;

use app\models\Model;

class SymptompLogs extends Model
{
    protected $table = 'symptom_logs';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'sl.id',
            'sl.patient_id',
            'sl.date',
            'sl.cough',
            'sl.fever',
            'sl.temperature',
            'sl.chest_pain',
            'sl.night_sweats',
            'sl.fatigue_level',
            'sl.appetite_loss',
            'sl.shortness_of_breath',
            '.created_at',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table im";
    }

    

}