<?php

namespace app\models;

use app\models\Model;

class EPrescription extends Model {
    protected $table = 'e_prescriptions';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
           'pr.id',
           'pr.prescription_code',
           'pr.patient_id',
           'pr.doctor_id',
           'pr.vitals_id',
           'pr.diagnosis',
           'pr.advice',
           'pr.follow_up_date',
           'pr.created_at', 
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table pr";
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            prescription_code,
            patient_id,
            doctor_id,
            vitals_id,
            diagnosis,
            advice,
            follow_up_date,
            created_at
        ) VALUES (
            :prescription_code,
            :patient_id,
            :doctor_id,
            :vitals_id,
            :diagnosis,
            :advice,
            :follow_up_date,
            NOW()
        )";

        $this->db->query($sql);

        $this->db->bind(':prescription_code', $data['prescription_code']);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':vitals_id', $data['vitals_id']);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':advice', $data['advice']);
        $this->db->bind(':follow_up_date', $data['follow_up_date']);

        return $this->db->execute();
    }
}