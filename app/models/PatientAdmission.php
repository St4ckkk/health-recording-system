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
            'pa.transferred_date',
            'pa.transferred_to',
            'pa.referral_date',
            'pa.referred_to',
            'pa.reason',
            'pa.ward',
            'pa.bed_no',
            'pa.status',
            'pa.remarks',
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


    public function updateStatus($data)
    {
        $fields = ['status' => $data['status']];

        // Add fields based on status
        switch ($data['status']) {
            case 'discharged':
                if (empty($data['discharge_date'])) {
                    return ['error' => 'Discharge date is required'];
                }
                $fields['discharge_date'] = $data['discharge_date'];
                break;

            case 'referred':
                if (empty($data['discharge_date']) || empty($data['referred_to'])) {
                    return ['error' => 'Referral date and doctor name are required'];
                }
                $fields['discharge_date'] = $data['discharge_date'];
                $fields['referred_to'] = $data['referred_to'];
                $fields['referral_date'] = $data['discharge_date'];
                break;

            case 'transferred':
                if (empty($data['discharge_date']) || empty($data['transferred_to'])) {
                    return ['error' => 'Transfer date and hospital name are required'];
                }
                $fields['discharge_date'] = $data['discharge_date'];
                $fields['transferred_to'] = $data['transferred_to'];
                $fields['transferred_date'] = $data['discharge_date'];
                break;
        }

        // Add remarks if provided
        if (!empty($data['remarks'])) {
            $fields['remarks'] = $data['remarks'];
        }

        // Build SQL query dynamically
        $setFields = [];
        $params = [':id' => $data['admission_id']];

        foreach ($fields as $key => $value) {
            $setFields[] = "$key = :$key";
            $params[":$key"] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $setFields) . ", updated_at = NOW() WHERE id = :id";

        $this->db->query($sql);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->execute() ? true : ['error' => 'Failed to update status'];
    }

    
    public function getAdmissionStats($doctorId)
    {
        // Get monthly admission counts
        $monthlySql = "SELECT 
                        DATE_FORMAT(admission_date, '%Y-%m') as month,
                        COUNT(*) as total_admissions,
                        SUM(CASE WHEN status = 'discharged' THEN 1 ELSE 0 END) as discharged,
                        SUM(CASE WHEN status = 'transferred' THEN 1 ELSE 0 END) as transferred,
                        AVG(CASE 
                            WHEN discharge_date IS NOT NULL 
                            THEN DATEDIFF(discharge_date, admission_date) 
                            ELSE NULL 
                        END) as avg_stay_duration
                    FROM {$this->table}
                    WHERE admitted_by = :doctor_id
                    AND admission_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND CURDATE()
                    GROUP BY DATE_FORMAT(admission_date, '%Y-%m')
                    ORDER BY month ASC";
        
        $this->db->query($monthlySql);
        $this->db->bind(':doctor_id', $doctorId);
        $monthlyStats = $this->db->resultSet();
        
        // Get ward distribution
        $wardSql = "SELECT 
                    ward,
                    COUNT(*) as count,
                    ROUND(COUNT(*) * 100.0 / (
                        SELECT COUNT(*) FROM {$this->table} 
                        WHERE admitted_by = :doctor_id
                        AND admission_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND CURDATE()
                    ), 1) as percentage
                FROM {$this->table}
                WHERE admitted_by = :doctor_id
                AND admission_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND CURDATE()
                GROUP BY ward
                ORDER BY count DESC";
        
        $this->db->query($wardSql);
        $this->db->bind(':doctor_id', $doctorId);
        $wardStats = $this->db->resultSet();
        
        // Get diagnosis distribution
        $diagnosisSql = "SELECT 
                        d.diagnosis,
                        COUNT(*) as count
                    FROM {$this->table} pa
                    JOIN diagnosis d ON pa.diagnosis_id = d.id
                    WHERE pa.admitted_by = :doctor_id
                    AND pa.admission_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND CURDATE()
                    GROUP BY d.diagnosis
                    ORDER BY count DESC
                    LIMIT 10";
        
        $this->db->query($diagnosisSql);
        $this->db->bind(':doctor_id', $doctorId);
        $diagnosisStats = $this->db->resultSet();
        
        // Get length of stay distribution
        $staySql = "SELECT 
                    CASE 
                        WHEN DATEDIFF(COALESCE(discharge_date, CURDATE()), admission_date) < 3 THEN 'Less than 3 days'
                        WHEN DATEDIFF(COALESCE(discharge_date, CURDATE()), admission_date) BETWEEN 3 AND 7 THEN '3-7 days'
                        WHEN DATEDIFF(COALESCE(discharge_date, CURDATE()), admission_date) BETWEEN 8 AND 14 THEN '8-14 days'
                        WHEN DATEDIFF(COALESCE(discharge_date, CURDATE()), admission_date) BETWEEN 15 AND 30 THEN '15-30 days'
                        ELSE 'More than 30 days'
                    END as stay_duration,
                    COUNT(*) as count
                FROM {$this->table}
                WHERE admitted_by = :doctor_id
                AND admission_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND CURDATE()
                GROUP BY stay_duration
                ORDER BY 
                    CASE stay_duration
                        WHEN 'Less than 3 days' THEN 1
                        WHEN '3-7 days' THEN 2
                        WHEN '8-14 days' THEN 3
                        WHEN '15-30 days' THEN 4
                        WHEN 'More than 30 days' THEN 5
                    END";
        
        $this->db->query($staySql);
        $this->db->bind(':doctor_id', $doctorId);
        $stayStats = $this->db->resultSet();
        
        // Get summary statistics
        $summarySql = "SELECT 
                        COUNT(*) as total_admissions,
                        COUNT(DISTINCT patient_id) as unique_patients,
                        SUM(CASE WHEN status = 'admitted' THEN 1 ELSE 0 END) as current_admissions,
                        SUM(CASE WHEN status = 'discharged' THEN 1 ELSE 0 END) as total_discharged,
                        SUM(CASE WHEN status = 'transferred' THEN 1 ELSE 0 END) as total_transferred,
                        ROUND(AVG(CASE 
                            WHEN discharge_date IS NOT NULL 
                            THEN DATEDIFF(discharge_date, admission_date) 
                            ELSE NULL 
                        END), 1) as avg_stay_duration,
                        MAX(CASE 
                            WHEN discharge_date IS NOT NULL 
                            THEN DATEDIFF(discharge_date, admission_date) 
                            ELSE NULL 
                        END) as max_stay_duration
                    FROM {$this->table}
                    WHERE admitted_by = :doctor_id
                    AND admission_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND CURDATE()";
        
        $this->db->query($summarySql);
        $this->db->bind(':doctor_id', $doctorId);
        $summaryStats = $this->db->single();
        
        return [
            'monthly' => $monthlyStats,
            'wards' => $wardStats,
            'diagnoses' => $diagnosisStats,
            'stay_duration' => $stayStats,
            'summary' => $summaryStats
        ];
    }
    
}