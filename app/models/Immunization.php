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
            'im.next_date',
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
                p.last_name as patient_last_name
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

}