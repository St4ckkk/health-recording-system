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
            'd.diagnosis',
            'd.notes',
            'a.allergy_name'
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
}