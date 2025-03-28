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

        // Debug query
        $this->db->query("SELECT * FROM {$this->table} WHERE tracking_number = :tracking_number");
        $this->db->bind(':tracking_number', $trackingNumber);
        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            error_log("Found appointment with tracking number: " . $trackingNumber . ", ID: " . $result->id);
            return $result;
        }

        error_log("No appointment found with tracking number: " . $trackingNumber);

        // Try a direct query to see all appointments
        $this->db->query("SELECT id, tracking_number FROM {$this->table} ORDER BY id DESC LIMIT 10");
        $recentAppointments = $this->db->resultSet();

        error_log("Recent appointments in the database:");
        foreach ($recentAppointments as $appt) {
            error_log("ID: " . $appt->id . ", Tracking Number: " . $appt->tracking_number);
        }

        return null;
    }

    /**
     * Get appointments for a specific doctor on a specific date
     * 
     * @param int $doctorId The doctor ID
     * @param string $date The date in Y-m-d format
     * @return array The appointments
     */
    public function getAppointmentsByDoctorAndDate($doctorId, $date)
    {
        // Debug log
        error_log("getAppointmentsByDoctorAndDate: doctorId=$doctorId, date=$date");

        $this->db->query('SELECT * FROM appointments WHERE doctor_id = :doctor_id AND appointment_date = :date');
        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':date', $date);

        $result = $this->db->resultSet();

        // Debug log
        error_log("getAppointmentsByDoctorAndDate: found " . count($result) . " appointments");

        return $result;
    }

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

    /**
     * Get upcoming appointments for a specific doctor
     * 
     * @param int $doctorId The doctor ID
     * @param int $limit Optional limit of appointments to return
     * @return array The upcoming appointments
     */
    public function getUpcomingAppointmentsByDoctorId($doctorId, $limit = 10)
    {
        $this->db->query('
          SELECT a.*, 
                 p.first_name as patient_first_name, 
                 p.last_name as patient_last_name,
                 p.middle_name as patient_middle_name,
                 p.suffix as patient_suffix
          FROM appointments a
          JOIN patients p ON a.patient_id = p.id
          WHERE a.doctor_id = :doctor_id
          AND a.appointment_date >= CURDATE()
          ORDER BY a.appointment_date ASC, a.appointment_time ASC
          LIMIT :limit
      ');

        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':limit', $limit);

        $appointments = $this->db->resultSet();

        // Format patient names and appointment details
        foreach ($appointments as &$appointment) {
            $appointment->patient_name = trim(
                $appointment->patient_first_name . ' ' .
                ($appointment->patient_middle_name ? $appointment->patient_middle_name . ' ' : '') .
                $appointment->patient_last_name .
                ($appointment->patient_suffix ? ' ' . $appointment->patient_suffix : '')
            );

            // Format date and time for display
            $appointment->formatted_date = date('M j, Y', strtotime($appointment->appointment_date));
            $appointment->formatted_time = date('g:i A', strtotime($appointment->appointment_time));
        }

        return $appointments;
    }

    /**
     * Insert a new appointment
     * 
     * @param array $data The appointment data
     * @return bool|int The ID of the inserted appointment or false on failure
     */
    public function insert($data)
    {
        try {
            $this->db->query('INSERT INTO appointments (
              patient_id,
              doctor_id,
              appointment_date,
              appointment_time,
              reason,
              appointment_type,
              status,
              tracking_number,
              special_instructions,
              created_at,
              updated_at
          ) VALUES (
              :patient_id,
              :doctor_id,
              :appointment_date,
              :appointment_time,
              :reason,
              :appointment_type,
              :status,
              :tracking_number,
              :special_instructions,
              :created_at,
              :updated_at
          )');

            // Bind values
            $this->db->bind(':patient_id', $data['patient_id']);
            $this->db->bind(':doctor_id', $data['doctor_id']);
            $this->db->bind(':appointment_date', $data['appointment_date']);
            $this->db->bind(':appointment_time', $data['appointment_time']);
            $this->db->bind(':reason', $data['reason']);
            $this->db->bind(':appointment_type', $data['appointment_type']);
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':tracking_number', $data['tracking_number']);
            $this->db->bind(':special_instructions', $data['special_instructions'] ?? '');
            $this->db->bind(':created_at', $data['created_at']);
            $this->db->bind(':updated_at', $data['updated_at']);

            // Execute
            if ($this->db->execute()) {
                return $this->db->lastInsertId();
            }

            return false;
        } catch (\Exception $e) {
            error_log("Error in Appointment::insert: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an appointment
     * 
     * @param int $id The appointment ID
     * @param array $data The appointment data
     * @return bool True on success, false on failure
     */
    public function update($id, $data)
    {
        try {
            error_log("Starting appointment update for ID: $id");
            error_log("Update data: " . print_r($data, true));

            $sql = 'UPDATE ' . $this->table . ' SET ';
            $updates = [];
            $bindings = [':id' => $id];

            foreach ($data as $key => $value) {
                $updates[] = $key . ' = :' . $key;
                $bindings[':' . $key] = $value;
            }

            $sql .= implode(', ', $updates);
            $sql .= ' WHERE id = :id';

            error_log("SQL query: $sql");
            error_log("Bindings: " . print_r($bindings, true));

            $this->db->query($sql);

            foreach ($bindings as $param => $value) {
                $this->db->bind($param, $value);
            }

            $result = $this->db->execute();
            error_log("Update execution result: " . ($result ? 'success' : 'failure'));


            return $result;
        } catch (\Exception $e) {
            error_log("Exception in Appointment::update: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

}

