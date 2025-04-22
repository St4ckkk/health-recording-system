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
                created_at,
                diagnosis_id,
                symptoms_id,
                treatment_records_id,
                admission_id,
                e_prescription_id,
                immunization_id,
                record_type
            ) VALUES (
                :patient_id,
                :doctor_id,
                :appointment_id,
                :vitals_id,
                :lab_result_id,
                :medication_id,
                :created_at,
                :diagnosis_id,
                :symptoms_id,
                :treatment_records_id,
                :admission_id,
                :e_prescription_id,
                :immunization_id,
                :record_type

            )");

            // Bind values
            $this->db->bind(':patient_id', $data['patient_id']);
            $this->db->bind(':doctor_id', $data['doctor_id']);
            $this->db->bind(':appointment_id', $data['appointment_id'] ?? null);
            $this->db->bind(':vitals_id', $data['vitals_id'] ?? null);
            $this->db->bind(':lab_result_id', $data['lab_result_id'] ?? null);
            $this->db->bind(':medication_id', $data['medication_id'] ?? null);
            $this->db->bind(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'));
            $this->db->bind(':diagnosis_id', $data['diagnosis_id'] ?? null);
            $this->db->bind(':symptoms_id', $data['symptoms_id'] ?? null);
            $this->db->bind(':treatment_records_id', $data['treatment_records_id'] ?? null);
            $this->db->bind(':admission_id', $data['admission_id'] ?? null);
            $this->db->bind(':e_prescription_id', $data['e_prescription_id'] ?? null);
            $this->db->bind(':immunization_id', $data['immunization_id'] ?? null);
            $this->db->bind(':record_type', $data['record_type'] ?? null);

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


    public function getMedicalRecordsStats()
    {
        $this->db->query("SELECT
            COUNT(*) as total_records,
            COUNT(DISTINCT patient_id) as unique_patients,
            COUNT(DISTINCT doctor_id) as unique_doctors,
            COUNT(DISTINCT appointment_id) as unique_appointments,
            COUNT(DISTINCT medication_id) as unique_medications,
            COUNT(DISTINCT diagnosis_id) as unique_diagnoses,
            COUNT(DISTINCT symptoms_id) as unique_symptoms,
            COUNT(DISTINCT treatment_records_id) as unique_treatment_records,
            COUNT(DISTINCT admission_id) as unique_admissions,
            COUNT(DISTINCT e_prescription_id) as unique_e_prescriptions,
            COUNT(DISTINCT immunization_id) as unique_immunizations,
            COUNT(DISTINCT vitals_id) as unique_vitals,
            COUNT(DISTINCT lab_result_id) as unique_lab_results 
            FROM {$this->table}");

        return $this->db->single();
    }

    public function getRecentMedicalRecords($limit = 5)
    {
        $query = "SELECT mr.*, 
                CONCAT(p.first_name, ' ', p.last_name) as patient_name,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                diag.diagnosis as diagnosis
                FROM {$this->table} mr
                LEFT JOIN patients p ON mr.patient_id = p.id
                LEFT JOIN doctors d ON mr.doctor_id = d.id
                LEFT JOIN diagnosis diag ON mr.diagnosis_id = diag.id
                ORDER BY mr.created_at DESC
                LIMIT :limit";

        $this->db->query($query);
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }
}