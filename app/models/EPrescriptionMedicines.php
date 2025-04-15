<?php

namespace app\models;

use app\models\Model;

class EPrescriptionMedicines extends Model {
    protected $table = 'e_prescription_medicines';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
           'prmed.id',
           'prmed.e_prescription_id',
           'prmed.medicine_name',
           'prmed.dosage',
           'prmed.duration',
           'prmed.special_instructions',
        ];
        return "SELECT " . implode(', ', $fields) . " FROM $this->table prmed";
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            e_prescription_id,
            medicine_name,
            -- quantity,
            dosage,
            duration,
            special_instructions
        ) VALUES (
            :e_prescription_id,
            :medicine_name,
            -- :quantity,
            :dosage,
            :duration,
            :special_instructions
        )";

        $this->db->query($sql);

        $this->db->bind(':e_prescription_id', $data['e_prescription_id']);
        $this->db->bind(':medicine_name', $data['medicine_name']);
        // $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':duration', $data['duration']);
        $this->db->bind(':special_instructions', $data['special_instructions']);

        return $this->db->execute();
    }

    public function insertBatch($prescriptionId, $medications)
    {
        $success = true;
        foreach ($medications as $medication) {
            $medication['e_prescription_id'] = $prescriptionId;
            if (!$this->insert($medication)) {
                $success = false;
            }
        }
        return $success;
    }
}