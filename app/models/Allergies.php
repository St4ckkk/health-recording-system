<?php

namespace app\models;

use app\models\Model;

class Allergies extends Model
{
    protected $table = 'allergies';

    public function __construct()
    {
        parent::__construct();
    }


    private function buildBaseQuery(bool $includeJoins = false): string
    {
        $fields = [
            'a.id',
            'a.patient_id',
            'a.allergy_type',
            'a.allery_name',
            'a.severity',
            'a.reaction',
            'a.recorded_at',
            'a.notes',
        ];

        $query = "SELECT " . implode(', ', $fields) . " FROM {$this->table} p";
        return $query;
    }


    public function insert($data)
    {
        $this->db->query("INSERT INTO allergies (patient_id, allergy_type, allergy_name, severity, reaction, recorded_at, notes) 
                          VALUES (:patient_id, :allergy_type, :allergy_name, :severity, :reaction, NOW(), :notes)");

        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':allergy_type', $data['allergy_type']);
        $this->db->bind(':allergy_name', $data['allergy_name']);
        $this->db->bind(':severity', $data['severity']);
        $this->db->bind(':reaction', $data['reaction']);
        $this->db->bind(':notes', $data['notes']);


        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }


    public function getByPatientId($patientId)
    {
        $this->db->query("SELECT * FROM allergies WHERE patient_id = :patient_id ORDER BY date DESC");
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }





    public function getPatientAllergies($patientId)
    {
        $sql = "SELECT id, allergy_type, allergy_name, severity,
                reaction 
                FROM {$this->table} 
                WHERE patient_id = :patient_id 
                ORDER BY recorded_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

}