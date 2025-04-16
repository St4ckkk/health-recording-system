<?php

namespace app\models;

use app\models\Model;

class EPrescription extends Model
{
    protected $table = 'e_prescriptions';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'pr.id',
            'pr.prescription_code',
            'pr.patient_id',
            'pr.doctor_id',
            'pr.vitals_id',
            'pr.diagnosis',
            'pr.advice',
            'pr.follow_up_date',
            'pr.created_at',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table pr";
    }

    public function insert($data)
    {
        $sql = "INSERT INTO e_prescriptions (
            prescription_code,
            patient_id,
            doctor_id,
            vitals_id,
            diagnosis,
            advice,
            follow_up_date,
            created_at
        ) VALUES (
            :prescription_code,
            :patient_id,
            :doctor_id,
            :vitals_id,
            :diagnosis,
            :advice,
            :follow_up_date,
            :created_at
        )";

        $this->db->query($sql);
        $this->db->bind(':prescription_code', $data['prescription_code']);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':vitals_id', $data['vitals_id']);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':advice', $data['advice']);
        $this->db->bind(':follow_up_date', $data['follow_up_date']);
        $this->db->bind(':created_at', $data['created_at']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function getPrescriptionsForPatient($patientId)
    {
        $sql = "SELECT p.*, 
                       d.first_name as doctor_first_name, 
                       d.last_name as doctor_last_name,
                       d.specialization as doctor_specialization
                FROM {$this->table} p
                LEFT JOIN doctors d ON p.doctor_id = d.id
                WHERE p.patient_id = :patient_id
                ORDER BY p.created_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function getPrescriptionWithDetails($prescriptionId)
    {
        $sql = "SELECT p.*, 
                       d.first_name as doctor_first_name, 
                       d.last_name as doctor_last_name,
                       d.specialization as doctor_specialization,
                       v.temperature, v.blood_pressure, v.heart_rate
                FROM {$this->table} p
                LEFT JOIN doctors d ON p.doctor_id = d.id
                LEFT JOIN vitals v ON p.vitals_id = v.id
                WHERE p.id = :prescription_id";

        $this->db->query($sql);
        $this->db->bind(':prescription_id', $prescriptionId);

        return $this->db->single();
    }
}