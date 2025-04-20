<?php

namespace app\models;

use app\models\Model;
use app\models\VitalsHistory;


class Vitals extends Model
{
    protected $table = 'vitals';
    protected $vitalsHistory;


    public function __construct()
    {
        parent::__construct();
        $this->vitalsHistory = new VitalsHistory();

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

    public function getAllVitals()
    {
        $query = $this->buildBaseQuery();
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function getLatestVitalsByPatientId($patientId)
    {
        $query = $this->buildBaseQuery() . " WHERE v.patient_id = :patient_id ORDER BY v.recorded_at DESC LIMIT 1";
        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        return $this->db->single();
    }

    public function insert($data)
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

    public function addVitals($patientId, $vitalsData)
    {
        $currentDateTime = date('Y-m-d H:i:s');

        // Prepare vitals data
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

        // Check if patient already has vitals
        $existingVitals = $this->getLatestVitalsByPatientId($patientId);

        // Always save to vitals history before any changes
        if ($existingVitals) {
            $historyData = (array) $existingVitals;
            $this->vitalsHistory->insertHistory($historyData);
            return $this->update($patientId, $data);
        }

        // If no existing vitals, create new record
        return $this->insert($data);
    }

    // Add this new update method
    public function update($patientId, $data)
    {
        $sql = "UPDATE {$this->table} SET 
            blood_pressure = :blood_pressure,
            blood_pressure_date = :blood_pressure_date,
            temperature = :temperature,
            temperature_date = :temperature_date,
            heart_rate = :heart_rate,
            heart_rate_date = :heart_rate_date,
            respiratory_rate = :respiratory_rate,
            respiratory_rate_date = :respiratory_rate_date,
            oxygen_saturation = :oxygen_saturation,
            oxygen_saturation_date = :oxygen_saturation_date,
            glucose_level = :glucose_level,
            glucose_date = :glucose_date,
            weight = :weight,
            weight_date = :weight_date,
            height = :height,
            height_date = :height_date,
            recorded_at = NOW()
            WHERE patient_id = :patient_id";

        $this->db->query($sql);

        $this->db->bind(':patient_id', $patientId);
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

    public function getVitalsTrends($doctorId)
    {
        $sql = "SELECT 
                    DATE_FORMAT(v.recorded_at, '%Y-%m-%d') as date,
                    AVG(SUBSTRING_INDEX(v.blood_pressure, '/', 1)) as systolic,
                    AVG(SUBSTRING_INDEX(v.blood_pressure, '/', -1)) as diastolic,
                    AVG(v.temperature) as temperature,
                    AVG(v.heart_rate) as heart_rate,
                    AVG(v.respiratory_rate) as respiratory_rate,
                    AVG(v.oxygen_saturation) as oxygen_saturation,
                    AVG(v.glucose_level) as glucose_level
                FROM {$this->table} v
                JOIN medical_records mr ON v.patient_id = mr.patient_id AND mr.doctor_id = :doctor_id
                GROUP BY DATE_FORMAT(v.recorded_at, '%Y-%m-%d')
                ORDER BY date ASC
                LIMIT 30";
                
        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);
        
        return $this->db->resultSet();
    }
}