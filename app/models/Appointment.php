<?php

namespace app\models;

use app\models\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAppointmentByTrackingNumber($trackingNumber)
    {
        error_log("Looking for appointment with tracking number: " . $trackingNumber);

        if (empty($trackingNumber)) {
            error_log("Empty tracking number provided");
            return null;
        }

        $trackingNumber = trim($trackingNumber);

        return $this->getSingleByField('tracking_number', $trackingNumber);
    }

    // public function getLastError() {
    //     if ($this->db) {
    //         return $this->db->errorInfo();
    //     }
    //     return null;
    // }

    /**
     * Get all appointments with patient and doctor information
     * 
     * @return array
     */
    public function getAllAppointments()
    {
        $this->db->query("SELECT a.*, p.first_name, p.last_name, p.contact_number, p.email, p.patient_id, 
                  d.first_name as doctor_first_name, d.last_name as doctor_last_name, 
                  d.specialization, 
                  COALESCE(a.appointment_type, 'Checkup') as type
                  FROM {$this->table} a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  ORDER BY a.appointment_date DESC, a.appointment_time DESC");

        $result = $this->db->resultSet();
        error_log("Retrieved " . count($result) . " appointments in getAllAppointments");
        return $result;
    }

    /**
     * Get today's appointments
     * 
     * @return array
     */
    public function getTodayAppointments()
    {
        $today = date('Y-m-d');
        $this->db->query("SELECT a.*, p.first_name, p.last_name, p.contact_number, p.email, p.patient_id, 
                  d.first_name as doctor_first_name, d.last_name as doctor_last_name, 
                  d.specialization
                  FROM {$this->table} a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  WHERE DATE(a.appointment_date) = :today
                  ORDER BY a.appointment_time ASC");
        $this->db->bind(':today', $today);

        return $this->db->resultSet();
    }

    /**
     * Get upcoming appointments
     * 
     * @return array
     */
    public function getUpcomingAppointments()
    {
        $today = date('Y-m-d');
        $this->db->query("SELECT a.*, p.first_name, p.last_name, p.contact_number, p.email, p.patient_id, 
                  d.first_name as doctor_first_name, d.last_name as doctor_last_name, 
                  d.specialization
                  FROM {$this->table} a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  WHERE a.appointment_date > :today
                  ORDER BY a.appointment_date ASC, a.appointment_time ASC");
        $this->db->bind(':today', $today);

        return $this->db->resultSet();
    }

    /**
     * Get past appointments
     * 
     * @return array
     */
    public function getPastAppointments()
    {
        $today = date('Y-m-d');
        $this->db->query("SELECT a.*, p.first_name, p.last_name, p.contact_number, p.email, p.patient_id, 
                  d.first_name as doctor_first_name, d.last_name as doctor_last_name, 
                  d.specialization
                  FROM {$this->table} a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  WHERE a.appointment_date < :today OR 
                        (a.appointment_date = :today AND a.status IN ('completed', 'no-show', 'cancelled'))
                  ORDER BY a.appointment_date DESC, a.appointment_time DESC");
        $this->db->bind(':today', $today);

        return $this->db->resultSet();
    }

    /**
     * Get appointment by ID with patient and doctor details
     * 
     * @param int $id
     * @return object|null
     */
    /**
     * Get an appointment by its ID with all related information
     * 
     * @param int $id The appointment ID
     * @return object|false The appointment object or false if not found
     */
    public function getAppointmentById($id)
    {
        $this->db->query("SELECT a.*, p.first_name, p.last_name, p.contact_number, p.email, p.patient_id, 
                  d.first_name as doctor_first_name, d.last_name as doctor_last_name, 
                  d.specialization, 
                  COALESCE(a.appointment_type, 'Checkup') as type
                  FROM {$this->table} a
                  LEFT JOIN patients p ON a.patient_id = p.id
                  LEFT JOIN doctors d ON a.doctor_id = d.id
                  WHERE a.id = :id");
        $this->db->bind(':id', $id);

        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            return $result;
        }

        return false;
    }

    /**
     * Get appointment statistics
     * 
     * @return array
     */
    public function getAppointmentStats()
    {
        $today = date('Y-m-d');

        // Get today's appointments count
        $this->db->query("SELECT COUNT(*) as count FROM {$this->table} WHERE DATE(appointment_date) = :today");
        $this->db->bind(':today', $today);
        $todayResult = $this->db->single();
        $todayCount = $todayResult ? $todayResult->count : 0;

        // Get pending appointments count
        $this->db->query("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'pending'");
        $pendingResult = $this->db->single();
        $pendingCount = $pendingResult ? $pendingResult->count : 0;

        // Get cancelled appointments count
        $this->db->query("SELECT COUNT(*) as count FROM {$this->table} WHERE status = 'cancelled'");
        $cancelledResult = $this->db->single();
        $cancelledCount = $cancelledResult ? $cancelledResult->count : 0;

        return [
            'today' => $todayCount,
            'pending' => $pendingCount,
            'cancelled' => $cancelledCount
        ];
    }
}