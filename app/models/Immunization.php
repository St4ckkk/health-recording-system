<?php

namespace app\models;

use app\models\Model;

class Immunization extends Model
{
    protected $table = 'immunization';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'im.id',
            'im.patient_id',
            'im.doctor_id',
            'im.vaccine_id',
            'im.immunization_date',
            'im.administrator',
            'lot_number',
            'im.next_due',
            'im.notes',
            'im.created_at',
            'im.updated_at',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table im";
    }

    public function getPatientImmunizations($patientId)
    {
        $sql = "SELECT 
                im.*,
                v.name as vaccine_name,
                v.manufacturer,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as doctor_specialization,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name,
                p.id as patient_id,
                p.patient_reference_number,
                p.age
            FROM {$this->table} im
            LEFT JOIN vaccines v ON im.vaccine_id = v.id
            LEFT JOIN doctors d ON im.doctor_id = d.id
            LEFT JOIN patients p ON im.patient_id = p.id
            WHERE im.patient_id = :patient_id
            ORDER BY im.immunization_date DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function getImmunizationById($id)
    {
        $sql = "SELECT 
                im.*,
                v.name as vaccine_name,
                v.manufacturer,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name,
                d.specialization as doctor_specialization,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name,
                p.id as patient_id,
                p.patient_reference_number,
                p.age
            FROM {$this->table} im
            LEFT JOIN vaccines v ON im.vaccine_id = v.id
            LEFT JOIN doctors d ON im.doctor_id = d.id
            LEFT JOIN patients p ON im.patient_id = p.id
            WHERE im.id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);

        return $this->db->single();
    }

    public function insert($data)
    {
        $this->db->query("INSERT INTO {$this->table} (patient_id, doctor_id, vaccine_id, immunization_date, administrator, lot_number, next_due, notes, created_at, updated_at) 
                          VALUES (:patient_id, :doctor_id, :vaccine_id, :immunization_date, :administrator, :lot_number, :next_due, :notes, NOW(), NOW())");

        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':vaccine_id', $data['vaccine_id']);
        $this->db->bind(':immunization_date', $data['immunization_date']);
        $this->db->bind(':administrator', $data['administrator']);
        $this->db->bind(':lot_number', $data['lot_number']);
        $this->db->bind(':next_due', $data['next_date']);
        $this->db->bind(':notes', $data['notes']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
}