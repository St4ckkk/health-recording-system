<?php

namespace app\models;

use app\models\Model;

class LabResults extends Model
{
    protected $table = 'lab_results';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
            "l.id",
            "l.patient_id",
            "l.test_name",
            "l.result",
            "l.reference_range",
            "l.flag",
            "l.test_date",
            "l.notes",
            "l.created_at",
            "l.updated_at"  // Added missing quote here
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table l";
    }

    public function getAllLabResults() {
        $query = $this->buildBaseQuery();
        $stmt = $this->db->prepare($query);
        $stmt->execute();  
    }
    
    public function getRecentLabResults($patientId, $limit = 10) {
        $sql = "SELECT 
                l.*,
                d.first_name as doctor_first_name,
                d.last_name as doctor_last_name,
                d.specialization as doctor_specialization
            FROM {$this->table} l
            LEFT JOIN doctors d ON l.doctor_id = d.id
            WHERE l.patient_id = :patient_id
            ORDER BY l.test_date DESC
            LIMIT :limit";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    
}