<?php

namespace app\models;

use app\models\Model;

class Symptoms extends Model
{
    protected $table = 'symptoms';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'sl.id',
            'sl.patient_id',
            'sl.name',
            'sl.severity_level',
            'sl.notes',
            '.created_at',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table im";
    }

    public function insert($data)
    {
        $this->db->query("INSERT INTO symptoms (patient_id, name, severity_level, notes, created_at) 
                          VALUES (:patient_id, :name, :severity_level, :notes, NOW())");

        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':severity_level', $data['severity_level']);
        $this->db->bind(':notes', $data['notes']);


        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }


    public function getPatientSymptoms($patientId)
    {
        $this->db->query("SELECT * FROM symptoms WHERE patient_id = :patient_id ORDER BY created_at DESC");
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }



    public function getByPatientId($patientId)
    {
        $this->db->query("SELECT * FROM symptoms WHERE patient_id = :patient_id ORDER BY date DESC");
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM symptoms WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}