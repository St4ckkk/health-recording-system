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

    private function buildBaseQuery(bool $includeType = false): string
    {
        $typeField = $includeType ? ", COALESCE(a.appointment_type, 'Checkup') as type" : '';
        return "SELECT a.*, 
                p.first_name, p.last_name, p.middle_name, p.suffix, p.contact_number, p.email, p.patient_reference_number, p.id as patient_id, 
                d.first_name as doctor_first_name, d.last_name as doctor_last_name, 
                d.specialization{$typeField}
                FROM {$this->table} a
                LEFT JOIN patients p ON a.patient_id = p.id
                LEFT JOIN doctors d ON a.doctor_id = d.id";
    }

    public function getAppointmentByTrackingNumber($trackingNumber)
    {
        error_log("Looking for appointment with tracking number: $trackingNumber");

        if (empty($trackingNumber)) {
            error_log("Empty tracking number provided");
            return null;
        }

        $trackingNumber = trim($trackingNumber);
        $this->db->query("SELECT * FROM {$this->table} WHERE tracking_number = :tracking_number");
        $this->db->bind(':tracking_number', $trackingNumber);
        $result = $this->db->single();

        if ($this->db->rowCount() > 0) {
            error_log("Found appointment: $trackingNumber, ID: " . $result->id);
            return $result;
        }

        error_log("No appointment found: $trackingNumber");
        $this->logRecentAppointments();
        return null;
    }

    private function logRecentAppointments(int $limit = 10): void
    {
        $this->db->query("SELECT id, tracking_number FROM {$this->table} ORDER BY id DESC LIMIT $limit");
        $recent = $this->db->resultSet();

        error_log("Recent appointments:");
        foreach ($recent as $appt) {
            error_log("ID: $appt->id, Tracking: $appt->tracking_number");
        }
    }

    public function getAppointmentsByDoctorAndDate($doctorId, $date)
    {
        error_log("getAppointmentsByDoctorAndDate: doctorId=$doctorId, date=$date");

        $this->db->query('SELECT * FROM appointments WHERE doctor_id = :doctor_id AND appointment_date = :date');
        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':date', $date);

        $result = $this->db->resultSet();
        error_log("Found " . count($result) . " appointments");
        return $result;
    }

    public function getAllAppointments()
    {
        $sql = $this->buildBaseQuery(true) . " ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        $this->db->query($sql);
        $result = $this->db->resultSet();
        error_log("Retrieved " . count($result) . " appointments");
        return $result;
    }

    private function executeAppointmentQuery(string $where, array $params, string $order): array
    {
        $sql = $this->buildBaseQuery() . " WHERE $where ORDER BY $order";
        $this->db->query($sql);
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        return $this->db->resultSet();
    }

    public function getTodayAppointments()
    {
        return $this->executeAppointmentQuery(
            'DATE(a.appointment_date) = :today',
            [':today' => date('Y-m-d')],
            'a.appointment_time ASC'
        );
    }

    public function getUpcomingAppointments()
    {
        return $this->executeAppointmentQuery(
            'a.appointment_date > :today',
            [':today' => date('Y-m-d')],
            'a.appointment_date ASC, a.appointment_time ASC'
        );
    }

    public function getPastAppointments()
    {
        $today = date('Y-m-d');
        return $this->executeAppointmentQuery(
            '(a.appointment_date < :today OR (a.appointment_date = :today AND a.status IN ("completed", "no-show", "cancelled")))',
            [':today' => $today],
            'a.appointment_date DESC, a.appointment_time DESC'
        );
    }

    public function getAppointmentById($id)
    {
        $sql = $this->buildBaseQuery(true) . " WHERE a.id = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single() ?: false;
    }

    public function getAppointmentStats()
    {
        $this->db->query("SELECT 
            SUM(CASE WHEN DATE(appointment_date) = CURDATE() THEN 1 ELSE 0 END) as today,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled
            FROM {$this->table}");

        $result = $this->db->single();
        return [
            'today' => $result->today ?? 0,
            'pending' => $result->pending ?? 0,
            'cancelled' => $result->cancelled ?? 0
        ];
    }

    public function getUpcomingAppointmentsByDoctorId($doctorId, $limit = 10)
    {
        $this->db->query($this->buildBaseQuery() . "
            WHERE a.doctor_id = :doctor_id AND a.appointment_date >= CURDATE()
            ORDER BY a.appointment_date ASC, a.appointment_time ASC
            LIMIT :limit");

        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':limit', $limit);

        $appointments = $this->db->resultSet();
        return array_map([$this, 'formatAppointmentDetails'], $appointments);
    }

    private function formatAppointmentDetails(object $appointment): object
    {
        $appointment->patient_name = trim(
            "$appointment->patient_first_name " .
            ($appointment->patient_middle_name ? "$appointment->patient_middle_name " : '') .
            $appointment->patient_last_name .
            ($appointment->patient_suffix ? " $appointment->patient_suffix" : '')
        );

        $appointment->formatted_date = date('M j, Y', strtotime($appointment->appointment_date));
        $appointment->formatted_time = date('g:i A', strtotime($appointment->appointment_time));
        return $appointment;
    }

    public function insert(array $data)
    {
        try {
            $fields = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));

            $this->db->query("INSERT INTO appointments ($fields) VALUES ($placeholders)");

            foreach ($data as $key => $value) {
                $this->db->bind(":$key", $value);
            }

            return $this->db->execute() ? $this->db->lastInsertId() : false;
        } catch (\Exception $e) {
            error_log("Insert error: " . $e->getMessage());
            return false;
        }
    }

    public function checkInPatient($appointmentId, $additionalData = [])
    {
        return $this->update($appointmentId, array_merge(
            $additionalData,
            ['status' => 'checked_in', 'updated_at' => date('Y-m-d H:i:s')]
        ));
    }

    public function startAppointment($appointmentId, $additionalData = [])
    {
        return $this->update($appointmentId, array_merge(
            $additionalData,
            ['status' => 'in_progress', 'updated_at' => date('Y-m-d H:i:s')]
        ));
    }

    public function completeAppointment($appointmentId, $additionalData = [])
    {
        return $this->update($appointmentId, array_merge(
            $additionalData,
            ['status' => 'completed', 'updated_at' => date('Y-m-d H:i:s')]
        ));
    }


    public function followUpAppointment($appointmentId, $additionalData = [])
    {
        return $this->update($appointmentId, array_merge(
            $additionalData,
            ['status' => 'follow-up', 'updated_at' => date('Y-m-d H:i:s')]
        ));
    }

    public function getAppointmentsByPatientId($patientId)
    {
        $this->db->query("
            SELECT 
                a.*,
                p.first_name AS patient_first_name,
                p.last_name AS patient_last_name,
                p.middle_name AS patient_middle_name,
                p.suffix AS patient_suffix,
                p.email AS patient_email,
                p.contact_number AS patient_contact,
                p.patient_reference_number AS patient_reference_number,
                d.first_name AS doctor_first_name,
                d.last_name AS doctor_last_name,

                d.specialization AS doctor_specialty
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            JOIN doctors d ON a.doctor_id = d.id
            WHERE a.patient_id = :patient_id
            ORDER BY a.appointment_date DESC, a.appointment_time DESC
        ");

        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }
}