<?php

namespace app\models;

use app\models\Model;

class EPrescriptionMedicines extends Model
{
    protected $table = 'e_prescription_medicines';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'prmed.id',
            'prmed.e_prescription_id',
            'prmed.medicine_name',
            'prmed.dosage',
            'prmed.duration',
            'prmed.special_instructions',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table prmed";
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            e_prescription_id,
            medicine_name,
            -- quantity,
            dosage,
            duration,
            special_instructions
        ) VALUES (
            :e_prescription_id,
            :medicine_name,
            -- :quantity,
            :dosage,
            :duration,
            :special_instructions
        )";

        $this->db->query($sql);

        $this->db->bind(':e_prescription_id', $data['e_prescription_id']);
        $this->db->bind(':medicine_name', $data['medicine_name']);
        // $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':duration', $data['duration']);
        $this->db->bind(':special_instructions', $data['special_instructions']);

        return $this->db->execute();
    }

    public function insertBatch($prescriptionId, $medications)
    {
        $success = true;
        foreach ($medications as $medication) {
            $data = [
                'e_prescription_id' => $prescriptionId,
                'medicine_name' => $medication['medicine_name'],
                'dosage' => $medication['dosage'],
                'duration' => $medication['duration'],
                'special_instructions' => $medication['special_instructions'] ?? ''
            ];
            
            if (!$this->insert($data)) {
                $success = false;
                break;
            }
        }
        return $success;
    }

    public function getMedicationsForPrescription($prescriptionId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE e_prescription_id = :prescription_id 
                ORDER BY id ASC";

        $this->db->query($sql);
        $this->db->bind(':prescription_id', $prescriptionId);

        return $this->db->resultSet();
    }

    public function getMedicationsForPatient($patientId)
    {
        $sql = "SELECT m.*, p.created_at as prescribed_date, p.status
                FROM {$this->table} m
                JOIN e_prescriptions p ON m.e_prescription_id = p.id
                WHERE p.patient_id = :patient_id
                ORDER BY p.created_at DESC, m.id ASC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }
}