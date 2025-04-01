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

    public function getPatientById($id)
    {
        // Log the requested patient ID for debugging
        error_log("Attempting to get patient with ID: " . $id);

        // First try direct ID lookup
        $patient = $this->getById($id);

        // If not found and the ID looks like a patient reference number (e.g., PAT-20250328-688566)
        if (!$patient && is_string($id) && strpos($id, 'PAT-') === 0) {
            error_log("ID appears to be a reference number, trying to find by id");
            $patient = $this->getSingleByField('id', $id);
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
        return $this->getSingleByField('email', $email);
    }

    /**
     * Insert a new patient
     * 
     * @param array $data The patient data
     * @return bool|int The ID of the inserted patient or false on failure
     */
    public function insert($data)
    {
        try {
            error_log("Patient::insert - Starting patient insertion");

            $this->db->query('INSERT INTO patients (
              first_name,
              middle_name,
              last_name,
              suffix,
              date_of_birth,
              age,
              profile,
              gender,
              email,
              contact_number,
              address,
              created_at
          ) VALUES (
              :first_name,
              :middle_name,
              :last_name,
              :suffix,
              :date_of_birth,
              :age,
              :profile,
              :gender,
              :email,
              :contact_number,
              :address,
              :created_at
          )');

            // Bind values
            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':middle_name', $data['middle_name'] ?? null);
            $this->db->bind(':last_name', $data['last_name']);
            $this->db->bind(':suffix', $data['suffix'] ?? null);
            $this->db->bind(':date_of_birth', $data['date_of_birth']);
            $this->db->bind(':age', $data['age']);
            $this->db->bind(':profile', $data['profile']?? null);
            $this->db->bind(':gender', $data['gender']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':contact_number', $data['contact_number']);
            $this->db->bind(':address', $data['address']);
            $this->db->bind(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'));

            error_log("Patient::insert - All values bound, executing query");

            // Execute
            if ($this->db->execute()) {
                $patientId = $this->db->lastInsertId();
                error_log("Patient::insert - Patient inserted successfully with ID: $patientId");
                return $patientId;
            }

            return false;
        } catch (\Exception $e) {
            error_log("Patient::insert - Exception: " . $e->getMessage());
            error_log("Patient::insert - Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Update a patient
     * 
     * @param int $id The patient ID
     * @param array $data The patient data
     * @return bool True on success, false on failure
     */
    public function update($id, $data)
    {
        $this->db->query('UPDATE patients SET
          first_name = :first_name,
          middle_name = :middle_name,
          last_name = :last_name,
          suffix = :suffix,
          date_of_birth = :date_of_birth,
          age = :age,
          diagnosis = :diagnosis,
          status = :status,
          allergies = :allergies,
          blood_type = :blood_type,
          notes = :notes,
          profile = :profile,
          gender = :gender,
          email = :email,
          contact_number = :contact_number,
          address = :address,
          updated_at = :updated_at
      WHERE id = :id');

        // Add new bindings
        $this->db->bind(':diagnosis', $data['diagnosis'] ?? null);
        $this->db->bind(':status', $data['status'] ?? null);
        $this->db->bind(':allergies', $data['allergies'] ?? null);
        $this->db->bind(':blood_type', $data['blood_type'] ?? null);
        $this->db->bind(':notes', $data['notes'] ?? null);
        
        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':middle_name', $data['middle_name'] ?? null);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':suffix', $data['suffix'] ?? null);
        $this->db->bind(':date_of_birth', $data['date_of_birth']);
        $this->db->bind(':age', $data['age']);
        $this->db->bind(':profile', $data['profile']?? null);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':contact_number', $data['contact_number']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':updated_at', $data['updated_at'] ?? date('Y-m-d H:i:s'));

        // Execute
        return $this->db->execute();
    }

    /**
     * Get all patients
     * 
     * @return array The patients
     */
    public function getAllPatients()
    {
        $this->db->query('SELECT * FROM patients ORDER BY last_name, first_name');
        return $this->db->resultSet();
    }


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
}