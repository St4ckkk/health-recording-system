<?php

namespace app\models;

use app\models\Model;

class VitalsHistory extends Model
{
    protected $table = 'vital_history';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
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



    public function insertHistory($data)
    {
        $sql = "INSERT INTO {$this->table} (
            patient_id,
            blood_pressure,
            blood_pressure_date,
            temperature,
            temperature_date,
            heart_rate,
            heart_rate_date,
            respiratory_rate,
            respiratory_rate_date,
            oxygen_saturation,
            oxygen_saturation_date,
            glucose_level,
            glucose_date,
            weight,
            weight_date,
            height,
            height_date,
            recorded_at
        ) VALUES (
            :patient_id,
            :blood_pressure,
            :blood_pressure_date,
            :temperature,
            :temperature_date,
            :heart_rate,
            :heart_rate_date,
            :respiratory_rate,
            :respiratory_rate_date,
            :oxygen_saturation,
            :oxygen_saturation_date,
            :glucose_level,
            :glucose_date,
            :weight,
            :weight_date,
            :height,
            :height_date,
            NOW()
        )";

        $this->db->query($sql);

        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':blood_pressure', $data['blood_pressure']);
        $this->db->bind(':blood_pressure_date', $data['blood_pressure_date']);
        $this->db->bind(':temperature', $data['temperature']);
        $this->db->bind(':temperature_date', $data['temperature_date']);
        $this->db->bind(':heart_rate', $data['heart_rate']);
        $this->db->bind(':heart_rate_date', $data['heart_rate_date']);
        $this->db->bind(':respiratory_rate', $data['respiratory_rate']);
        $this->db->bind(':respiratory_rate_date', $data['respiratory_rate_date']);
        $this->db->bind(':oxygen_saturation', $data['oxygen_saturation']);
        $this->db->bind(':oxygen_saturation_date', $data['oxygen_saturation_date']);
        $this->db->bind(':glucose_level', $data['glucose_level']);
        $this->db->bind(':glucose_date', $data['glucose_date']);
        $this->db->bind(':weight', $data['weight']);
        $this->db->bind(':weight_date', $data['weight_date']);
        $this->db->bind(':height', $data['height']);
        $this->db->bind(':height_date', $data['height_date']);

        return $this->db->execute();
    }

    public function addVitalsHistory($patientId, $vitalsData)
    {
        $currentDateTime = date('Y-m-d H:i:s');

        $data = [
            'patient_id' => $patientId,
            'blood_pressure' => $vitalsData['blood_pressure'],
            'blood_pressure_date' => $currentDateTime,
            'temperature' => $vitalsData['temperature'],
            'temperature_date' => $currentDateTime,
            'heart_rate' => $vitalsData['heart_rate'],
            'heart_rate_date' => $currentDateTime,
            'respiratory_rate' => $vitalsData['respiratory_rate'],
            'respiratory_rate_date' => $currentDateTime,
            'oxygen_saturation' => $vitalsData['oxygen_saturation'],
            'oxygen_saturation_date' => $currentDateTime,
            'glucose_level' => $vitalsData['glucose_level'],
            'glucose_date' => $currentDateTime,
            'weight' => $vitalsData['weight'],
            'weight_date' => $currentDateTime,
            'height' => $vitalsData['height'],
            'height_date' => $currentDateTime
        ];

        return $this->insertHistory($data);
    }


}