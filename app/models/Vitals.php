<?php

namespace app\models;

use app\models\Model;

class Vitals extends Model
{
    protected $table = 'vitals';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
            'v.id',
            'v.patient_id',
            'v.blood_pressure',
            'v.blood_pressure_date',
            'v.temperature',
            'v.temperature_date',
            'v.heart_rate',
            'v.heart_rate_date',
            'v.respiratory_rate',
            'v.respiratory_rate_date',
            'v.oxygen_saturation',
            'v.oxygen_saturation_date',
            'v.glucose_level',
            'v.glucose_date',
            'v.weight',
            'v.weight_date',
            'v.height',
            'v.height_date',
            'v.recorded_at'
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table v";
    }

    public function getAllVitals() {
        $query = $this->buildBaseQuery();
        $stmt = $this->db->prepare($query);
        $stmt->execute();  
    }

    public function getLatestVitalsByPatientId($patientId) {
        $query = $this->buildBaseQuery() . " WHERE v.patient_id = :patient_id ORDER BY v.recorded_at DESC LIMIT 1";
        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        return $this->db->single();
    }
}