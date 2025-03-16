<?php

namespace app\models;

use app\models\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDoctors($status = null)
    {
        // Get all doctors with optional status filter
        if ($status) {
            $this->db->query("SELECT * FROM {$this->table} WHERE status = :status");
            $this->db->bind(':status', $status);
        } else {
            $this->db->query("SELECT * FROM {$this->table}");
        }
        return $this->db->resultSet();
    }

    public function getAllDoctorsWithDetails($status = null)
    {
        // Build the query with optional status filter
        $sql = "
            SELECT d.*, 
                   COUNT(DISTINCT ts.day) as available_days,
                   GROUP_CONCAT(DISTINCT ts.day ORDER BY 
                     CASE ts.day
                       WHEN 'Monday' THEN 1
                       WHEN 'Tuesday' THEN 2
                       WHEN 'Wednesday' THEN 3
                       WHEN 'Thursday' THEN 4
                       WHEN 'Friday' THEN 5
                       WHEN 'Saturday' THEN 6
                       WHEN 'Sunday' THEN 7
                     END SEPARATOR ', ') as days
            FROM {$this->table} d
            LEFT JOIN doctor_time_slots ts ON d.id = ts.doctor_id
        ";

        // Add status filter if provided
        if ($status) {
            $sql .= " WHERE d.status = :status";
        }

        // Complete the query
        $sql .= " GROUP BY d.id ORDER BY d.last_name, d.first_name";

        $this->db->query($sql);

        // Bind parameters if needed
        if ($status) {
            $this->db->bind(':status', $status);
        }

        return $this->db->resultSet();
    }

    public function getDoctorsWithTimeSlots()
    {
        $this->db->query("
            SELECT d.*, ts.day, ts.start_time, ts.end_time 
            FROM {$this->table} d
            LEFT JOIN doctor_time_slots ts ON d.id = ts.doctor_id
            ORDER BY d.id, ts.day
        ");

        return $this->db->resultSet();
    }

    public function getDoctorById($id)
    {
        return $this->getById($id);
    }

    public function getDoctorsBySpecialization($specialization)
    {
        return $this->getAll([
            'specialization' => $specialization,
            'status' => 'available'
        ]);
    }

    public function getFullName($doctor)
    {
        $fullName = $doctor->first_name;
        if (!empty($doctor->middle_name)) {
            $fullName .= ' ' . $doctor->middle_name;
        }
        $fullName .= ' ' . $doctor->last_name;
        if (!empty($doctor->suffix)) {
            $fullName .= ', ' . $doctor->suffix;
        }
        return $fullName;
    }
}