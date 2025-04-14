<?php

namespace app\models;

use app\models\Model;

class MedicineLogs extends Model
{
    protected $table = 'medicine_logs';

    public function __construct()
    {
        parent::__construct();
    }

    public function getMedicineLogs()
    {
        $query = "SELECT 
            ml.*,
            mi.name as medicine_name,
            mi.category as medicine_category,
            mi.form as medicine_form,
            CASE WHEN ml.doctor_id IS NOT NULL THEN CONCAT(d.first_name, ' ', d.last_name) ELSE NULL END as doctor_name,
            CASE WHEN ml.doctor_id IS NOT NULL THEN d.specialization ELSE NULL END as doctor_specialization,
            CASE WHEN ml.patient_id IS NOT NULL THEN CONCAT(p.first_name, ' ', p.last_name) ELSE NULL END as patient_name,
            p.id as patient_id,
            p.patient_reference_number,
            CASE WHEN ml.staff_id IS NOT NULL THEN CONCAT(s.first_name, ' ', s.last_name) ELSE NULL END as staff_name,
            s.role_id as staff_role_id,
            r.role_name as staff_role
        FROM {$this->table} ml
        LEFT JOIN medicine_inventory mi ON ml.medicine_id = mi.id
        LEFT JOIN doctors d ON ml.doctor_id = d.id
        LEFT JOIN patients p ON ml.patient_id = p.id
        LEFT JOIN staff s ON ml.staff_id = s.id
        LEFT JOIN roles r ON s.role_id = r.id
        ORDER BY ml.timestamp DESC";

        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO {$this->table} (
            medicine_id,
            patient_id,
            doctor_id,
            quantity,
            previous_stock,
            new_stock,
            remarks,
            timestamp,
            created_at,
            updated_at
        ) VALUES (
            :medicine_id,
            :patient_id,
            :doctor_id,
            :quantity,
            :previous_stock,
            :new_stock,
            :remarks,
            NOW(),
            :created_at,
            :updated_at
        )";

        $this->db->query($sql);

        // Bind values
        $this->db->bind(':medicine_id', $data['medicine_id']);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':previous_stock', $data['previous_stock']);
        $this->db->bind(':new_stock', $data['new_stock']);
        $this->db->bind(':remarks', $data['remarks']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

        return $this->db->execute() ? $this->db->lastInsertId() : false;
    }
}