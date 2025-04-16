<?php

namespace app\models;

use app\models\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnosis';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeJoins = false): string
    {
        $fields = [
            'd.id',
            'd.patient_id',
            'd.doctor_id',
            'd.diagnosis',
            'd.diagnosed_at',
            'd.notes',
            'd.status',
            'd.created_at',
            'd.updated_at'
        ];

        $query = "SELECT " . implode(', ', $fields) . " FROM {$this->table} d";
        return $query;
    }



    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            id,
            patient_id,
            doctor_id,
            diagnosis,
            diagnosed_at,
            notes
        ) VALUES (
            NULL,
            :patient_id,
            :doctor_id,
            :diagnosis,
            :diagnosed_at,
            :notes
        )";

        $this->db->query($sql);


        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':diagnosed_at', $data['diagnosed_at']);
        $this->db->bind(':notes', $data['notes']);

        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
}