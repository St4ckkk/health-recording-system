<?php

namespace app\models;

use app\models\Model;

class Medications extends Model
{
    protected $table = 'medications';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'm.id',
            'm.patient_id',
            'm.medication_id',
            'm.dosage',
            'm.frequency',
            'm.start_date',
            'm.prescribed_by',
            'm.purpose',
            "m.status",
            'm.created_at',
            'm.updated_at'
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table m";
    }

    public function getCurrentMedicationsByPatientId($patientId)
    {
        $sql = "SELECT 
                m.*,
                mi.name as medication_name,
                mi.form,
                mi.category,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as doctor_specialization,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name
            FROM {$this->table} m
            LEFT JOIN medicine_inventory mi ON m.medicine_id = mi.id
            LEFT JOIN doctors d ON m.prescribed_by = d.id
            LEFT JOIN patients p ON m.patient_id = p.id
            WHERE m.patient_id = :patient_id
            ORDER BY m.start_date DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }


    public function getPatientActiveMedications($patientId)
    {
        $sql = "SELECT 
                m.*,
                mi.name as medication_name,
                mi.form,
                mi.category,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as doctor_specialization,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name
            FROM {$this->table} m
            LEFT JOIN medicine_inventory mi ON m.medicine_id = mi.id
            LEFT JOIN doctors d ON m.prescribed_by = d.id
            LEFT JOIN patients p ON m.patient_id = p.id
            WHERE m.patient_id = :patient_id
            AND m.status = 'active'
            ORDER BY m.start_date DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function getPatientMedicationHistory($patientId)
    {
        $sql = "SELECT 
                m.*,
                mi.name as medication_name,
                mi.form,
                mi.category,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as doctor_specialization,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name
            FROM {$this->table} m
            LEFT JOIN medicine_inventory mi ON m.medicine_id = mi.id
            LEFT JOIN doctors d ON m.prescribed_by = d.id
            LEFT JOIN patients p ON m.patient_id = p.id
            WHERE m.patient_id = :patient_id
            AND m.status IN ('completed', 'discontinued')
            ORDER BY m.updated_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }


    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            patient_id,
            medicine_id,
            dosage,
            frequency,
            start_date,
            purpose,
            prescribed_by,
            status,
            created_at,
            updated_at
        ) VALUES (
            :patient_id,
            :medicine_id,
            :dosage,
            :frequency,
            :start_date,
            :purpose,
            :prescribed_by,
            'active',
            :created_at,
            :updated_at
        )";

        $this->db->query($sql);

        // Bind values
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':medicine_id', $data['medicine_id']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':frequency', $data['frequency']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':purpose', $data['purpose'] ?? 'Prescribed during checkup');
        $this->db->bind(':prescribed_by', $data['prescribed_by']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
}