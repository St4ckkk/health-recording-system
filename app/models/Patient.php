<?php

namespace app\models;

use app\models\Model;

class Patient extends Model
{
    protected $table = 'patients';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeJoins = false): string
    {
        $fields = [
            'p.id',
            'p.first_name',
            'p.middle_name',
            'p.last_name',
            'p.suffix',
            'p.date_of_birth',
            'p.age',
            'p.profile',
            'p.gender',
            'p.contact_number',
            'p.email',
            'p.address',
            'p.created_at',
            'p.updated_at',
            'p.patient_reference_number',
            'p.status',
            'p.insurance',
            // 'd.diagnosis',
            // 'd.notes',
            // 'a.allergy_name'
        ];

        $query = "SELECT " . implode(', ', $fields) . " FROM {$this->table} p";
        return $query;
    }

    public function getPatientById($id)
    {
        error_log("Attempting to get patient with ID: " . $id);

        $query = $this->buildBaseQuery() . "
            LEFT JOIN diagnosis d ON d.patient_id = p.id
            LEFT JOIN allergies a ON a.patient_id = p.id
            WHERE p.id = :id
            ORDER BY d.diagnosed_at DESC, a.recorded_at DESC
            LIMIT 1";

        $this->db->query($query);
        $this->db->bind(':id', $id);
        $patient = $this->db->single();

        if (!$patient && is_string($id) && strpos($id, 'PAT-') === 0) {
            $query = $this->buildBaseQuery() . "
                LEFT JOIN diagnosis d ON d.patient_id = p.id
                LEFT JOIN allergies a ON a.patient_id = p.id
                WHERE p.patient_reference_number = :ref
                ORDER BY d.diagnosed_at DESC, a.recorded_at DESC
                LIMIT 1";
            $this->db->query($query);
            $this->db->bind(':ref', $id);
            $patient = $this->db->single();
        }

        if (!$patient) {
            error_log("Patient not found with ID: " . $id);
        } else {
            error_log("Patient found: " . $patient->first_name . " " . $patient->last_name);
        }

        return $patient;
    }

    public function getPatientByEmail($email)
    {
        $query = $this->buildBaseQuery() . ' WHERE p.email = :email';
        $this->db->query($query);
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    // Remove the duplicate getAllPatients method at the bottom


    public function getPatientWithVitals($id)
    {
        $this->db->query('SELECT p.*, 
            v.blood_pressure, 
            v.temperature,
            v.heart_rate,
            v.respiratory_rate,
            v.oxygen_saturation,
            v.weight,
            v.height,
            v.recorded_at as vitals_recorded_at
        FROM patients p
        LEFT JOIN vitals v ON p.id = v.patient_id
        WHERE p.id = :id
        ORDER BY v.recorded_at DESC
        LIMIT 1');

        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Update the diagnosis distribution method
    public function getDiagnosisDistribution()
    {
        $query = "SELECT d.diagnosis, COUNT(*) as count 
                 FROM diagnosis d
                 GROUP BY d.diagnosis";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getPatientDemographics($doctorId)
    {
        // Age groups
        $ageGroupsSql = "SELECT 
                            CASE 
                                WHEN age < 18 THEN 'Under 18'
                                WHEN age BETWEEN 18 AND 30 THEN '18-30'
                                WHEN age BETWEEN 31 AND 45 THEN '31-45'
                                WHEN age BETWEEN 46 AND 60 THEN '46-60'
                                WHEN age > 60 THEN 'Over 60'
                            END as age_group,
                            COUNT(*) as count
                        FROM {$this->table} p
                        JOIN medical_records mr ON p.id = mr.patient_id AND mr.doctor_id = :doctor_id
                        GROUP BY age_group
                        ORDER BY 
                            CASE age_group
                                WHEN 'Under 18' THEN 1
                                WHEN '18-30' THEN 2
                                WHEN '31-45' THEN 3
                                WHEN '46-60' THEN 4
                                WHEN 'Over 60' THEN 5
                            END";
        
        $this->db->query($ageGroupsSql);
        $this->db->bind(':doctor_id', $doctorId);
        $ageGroups = $this->db->resultSet();
        
        // Gender distribution
        $genderSql = "SELECT 
                        gender,
                        COUNT(*) as count
                      FROM {$this->table} p
                      JOIN medical_records mr ON p.id = mr.patient_id AND mr.doctor_id = :doctor_id
                      GROUP BY gender";
        
        $this->db->query($genderSql);
        $this->db->bind(':doctor_id', $doctorId);
        $genderDistribution = $this->db->resultSet();
        
        // Insurance distribution
        $insuranceSql = "SELECT 
                            CASE WHEN insurance IS NULL OR insurance = '' THEN 'None' ELSE insurance END as insurance_type,
                            COUNT(*) as count
                         FROM {$this->table} p
                         JOIN medical_records mr ON p.id = mr.patient_id AND mr.doctor_id = :doctor_id
                         GROUP BY insurance_type
                         ORDER BY count DESC";
        
        $this->db->query($insuranceSql);
        $this->db->bind(':doctor_id', $doctorId);
        $insuranceDistribution = $this->db->resultSet();
        
        return [
            'age_groups' => $ageGroups,
            'gender_distribution' => $genderDistribution,
            'insurance_distribution' => $insuranceDistribution
        ];
    }
    
    public function insert($data)
    {
        // Generate patient reference number
        $referenceNumber = 'PAT-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

        $sql = "INSERT INTO {$this->table} (
            first_name,
            middle_name,
            last_name,
            suffix,
            date_of_birth,
            age,
            profile,
            gender,
            contact_number,
            email,
            address,
            patient_reference_number,
            status,
            insurance,
            created_at,
            updated_at
        ) VALUES (
            :first_name,
            :middle_name,
            :last_name,
            :suffix,
            :date_of_birth,
            :age,
            :profile,
            :gender,
            :contact_number,
            :email,
            :address,
            :patient_reference_number,
            'Active',
            :insurance,
            :created_at,
            :updated_at
        )";

        try {
            $this->db->query($sql);

            // Bind values
            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':middle_name', $data['middle_name'] ?? null);
            $this->db->bind(':last_name', $data['last_name']);
            $this->db->bind(':suffix', $data['suffix'] ?? null);
            $this->db->bind(':date_of_birth', $data['date_of_birth']);
            $this->db->bind(':age', $data['age']);
            $this->db->bind(':profile', $data['profile'] ?? null);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':contact_number', $data['contact_number']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':patient_reference_number', $referenceNumber);
            $this->db->bind(':insurance', $data['insurance'] ?? null);
            $this->db->bind(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'));
            $this->db->bind(':updated_at', $data['updated_at'] ?? date('Y-m-d H:i:s'));

            // Execute
            if ($this->db->execute()) {
                return $this->db->lastInsertId();
            }

            return false;
        } catch (\PDOException $e) {
            error_log('Patient insert error: ' . $e->getMessage());
            return false;
        }
    }
}