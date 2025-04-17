<?php

namespace app\models;

use app\models\Model;

class TreatmentRecords extends Model
{
    protected $table = 'treatment_records';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'tr.id',
            'tr.patient_id',
            'tr.doctor_id',
            'tr.treatment_type',
            'tr.regimen_summary',
            'tr.start_date',
            'tr.end_date',
            'tr.adherence_status',
            'tr.outcome',
            'tr.follow_up_notes',
            'tr.status',
            'tr.created_at',
            'tr.updated_at'
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table im";
    }

    public function getPatientTreatmentRecords($patientId)
    {
        $sql = "SELECT tr.*, 
                           d.first_name as doctor_first_name, 
                           d.last_name as doctor_last_name,
                           d.specialization as doctor_specialization
                        FROM {$this->table} tr
                        LEFT JOIN doctors d ON tr.doctor_id = d.id
                        WHERE tr.patient_id = :patient_id
                        ORDER BY tr.created_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function getTreatmentById($treatmentId)
    {
        $sql = "SELECT tr.*, 
                       d.first_name as doctor_first_name, 
                       d.last_name as doctor_last_name,
                       d.specialization as doctor_specialization,
                       p.first_name as patient_first_name,
                       p.last_name as patient_last_name
                FROM {$this->table} tr
                LEFT JOIN doctors d ON tr.doctor_id = d.id
                LEFT JOIN patients p ON tr.patient_id = p.id
                WHERE tr.id = :treatment_id";

        $this->db->query($sql);
        $this->db->bind(':treatment_id', $treatmentId);

        return $this->db->single();
    }

}