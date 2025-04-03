<?php

namespace app\models;

use app\models\Model;

class MedicalRecords extends Model
{
    protected $table = 'medical_records';


    public function __construct()
    {
        parent::__construct();
    }

    public function getMedicalRecordById($id)
    {
        return $this->getById($id);
    }


    public function insert($data)
    {
        try {
            error_log("MedicalRecords::insert - Starting medical record insertion");

            $this->db->query("INSERT INTO {$this->table} (
                patient_id,
                doctor_id,
                appointment_id,
                vitals_id,
                lab_result_id,
                medication_id,
                created_at
            ) VALUES (
                :patient_id,
                :doctor_id,
                :appointment_id,
                :vitals_id,
                :lab_result_id,
                :medication_id,
                :created_at
            )");

            // Bind values
            $this->db->bind(':patient_id', $data['patient_id']);
            $this->db->bind(':doctor_id', $data['doctor_id']);
            $this->db->bind(':appointment_id', $data['appointment_id'] ?? null);
            $this->db->bind(':vitals_id', $data['vitals_id'] ?? null);
            $this->db->bind(':lab_result_id', $data['lab_result_id'] ?? null);
            $this->db->bind(':medication_id', $data['medication_id'] ?? null);
            $this->db->bind(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'));

            error_log("MedicalRecords::insert - All values bound, executing query");

            if ($this->db->execute()) {
                $recordId = $this->db->lastInsertId();
                error_log("MedicalRecords::insert - Record inserted successfully with ID: $recordId");
                return $recordId;
            }

            return false;
        } catch (\Exception $e) {
            error_log("MedicalRecords::insert - Exception: " . $e->getMessage());
            error_log("MedicalRecords::insert - Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function update($id, $data)
    {
        $this->db->query("UPDATE {$this->table} SET
            vitals_id = :vitals_id,
            lab_result_id = :lab_result_id,
            medication_id = :medication_id,
            updated_at = :updated_at
            WHERE id = :id");

        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':vitals_id', $data['vitals_id'] ?? null);
        $this->db->bind(':lab_result_id', $data['lab_result_id'] ?? null);
        $this->db->bind(':medication_id', $data['medication_id'] ?? null);
        $this->db->bind(':updated_at', $data['updated_at'] ?? date('Y-m-d H:i:s'));

        return $this->db->execute();
    }






    public function getPatientVisitsWithDetails($patientId)
    {
        $this->db->query("
            SELECT 
                a.*,
                d.first_name as doctor_first_name,
                d.last_name as doctor_last_name,
                v.blood_pressure,
                v.temperature,
                v.respiratory_rate,
                v.heart_rate,
                v.weight,
                diag.diagnosis,
                diag.notes,
                mr.created_at as record_date,
                (SELECT appointment_date 
                 FROM appointments orig 
                 WHERE orig.id = a.original_appointment_id) as original_appointment_date,
                TIMESTAMPDIFF(MONTH, 
                    (SELECT appointment_date 
                     FROM appointments orig 
                     WHERE orig.id = a.original_appointment_id), 
                    a.appointment_date) as follow_up_duration
            FROM appointments a
            LEFT JOIN doctors d ON a.doctor_id = d.id
            LEFT JOIN patients p ON a.patient_id = p.id
            LEFT JOIN vitals v ON v.patient_id = a.patient_id
            LEFT JOIN diagnosis diag ON diag.patient_id = p.id
            LEFT JOIN {$this->table} mr ON mr.appointment_id = a.id
            WHERE a.patient_id = :patient_id
                AND a.is_follow_up = 1
                AND a.original_appointment_id IS NOT NULL
            ORDER BY a.appointment_date DESC, a.appointment_time DESC");

        $this->db->bind(':patient_id', $patientId);

        $visits = $this->db->resultSet();

        foreach ($visits as $visit) {
            if (!empty($visit->appointment_date)) {
                $visit->formatted_date = date('F d, Y', strtotime($visit->appointment_date));
            }

            $visit->appointment_type = $visit->appointment_type ?? 'Annual Physical';
            $visit->notes = $visit->notes ?? '';
            $visit->diagnosis = $visit->diagnosis ?? '';

            $visit->blood_pressure = $visit->blood_pressure ?? '';
            $visit->temperature = $visit->temperature ?? '';
            $visit->respiratory_rate = $visit->respiratory_rate ?? '';
            $visit->heart_rate = $visit->heart_rate ?? '';
            $visit->weight = $visit->weight ?? '';

            // Set is_follow_up flag if there are follow-up months
            $visit->is_follow_up = !empty($visit->follow_up_months);
        }

        return $visits;
    }
}