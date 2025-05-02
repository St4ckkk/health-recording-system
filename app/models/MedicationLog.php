<?php

namespace app\models;

use app\models\Model;

class MedicationLog extends Model
{
    protected $table = 'medication_logs';

    public function __construct()
    {
        parent::__construct();
    }

    public function getRecentLogs($patientId, $limit = 10)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE patient_id = :patient_id 
                ORDER BY taken_at DESC 
                LIMIT :limit";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    public function addLog($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (patient_id, medication_name, dosage, frequency, taken_at, status, notes) 
                VALUES 
                (:patient_id, :medication_name, :dosage, :frequency, :taken_at, :status, :notes)";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':medication_name', $data['medication_name']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':frequency', $data['frequency']);
        $this->db->bind(':taken_at', $data['taken_at']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':notes', $data['notes'] ?? null);

        return $this->db->execute();
    }

    public function updateLog($id, $data)
    {
        $sql = "UPDATE {$this->table} 
                SET status = :status, 
                    notes = :notes, 
                    updated_at = CURRENT_TIMESTAMP 
                WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':notes', $data['notes'] ?? null);

        return $this->db->execute();
    }

    public function getLogById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);

        return $this->db->single();
    }
}