<?php

namespace app\models;

use app\models\Model;

class PatientAdmission extends Model
{
    protected $table = 'patient_admissions';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'pa.id',
            'pa.patient_id',
            'pa.diagnosis_id',
            'pa.admitted_by',
            'pa.admission_date',
            'pa.discharge_date',
            'pa.reason',
            'pa.ward',
            'pa.bed_no',
            'pa.status',
            'pa.created_at',
            'pa.updated_at',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table pa";
    }

    public function getPatientAdmissions($patientId)
    {
        $sql = "SELECT pa.*, 
                       d.first_name as doctor_first_name, 
                       d.last_name as doctor_last_name,
                       d.specialization as doctor_specialization,
                       di.diagnosis as diagnosis_name,
                       di.notes as diagnosis_notes
                FROM {$this->table} pa
                LEFT JOIN doctors d ON pa.admitted_by = d.id
                LEFT JOIN diagnosis di ON pa.diagnosis_id = di.id
                WHERE pa.patient_id = :patient_id
                ORDER BY pa.created_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function getAdmissionById($admissionId)
    {
        $sql = "SELECT pa.*, 
                       d.first_name as doctor_first_name, 
                       d.last_name as doctor_last_name,
                       d.specialization as doctor_specialization,
                       di.diagnosis as diagnosis_name,
                       di.notes as diagnosis_notes
                FROM {$this->table} pa
                LEFT JOIN doctors d ON pa.admitted_by = d.id
                LEFT JOIN diagnosis di ON pa.diagnosis_id = di.id
                WHERE pa.id = :admission_id";

        $this->db->query($sql);
        $this->db->bind(':admission_id', $admissionId);

        return $this->db->single();
    }



    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            patient_id,
            diagnosis_id,
            admitted_by,
            admission_date,
            reason,
            ward,
            bed_no,
            status,
            created_at,
            updated_at
        ) VALUES (
            :patient_id,
            :diagnosis_id,
            :admitted_by,
            :admission_date,
            :reason,
            :ward,
            :bed_no,
            :status,
            NOW(),
            NOW()
        )";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':diagnosis_id', $data['diagnosis_id']);
        $this->db->bind(':admitted_by', $data['admitted_by']);
        $this->db->bind(':admission_date', $data['admission_date']);
        $this->db->bind(':reason', $data['reason']);
        $this->db->bind(':ward', $data['ward']);
        $this->db->bind(':bed_no', $data['bed_no']);
        $this->db->bind(':status', $data['status']);

        return $this->db->execute() ? $this->db->lastInsertId() : false;
    }

}