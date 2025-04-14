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
        return "SELECT a.id,
                a.original_appointment_id,
                a.patient_id,
                a.doctor_id,
                a.appointment_date,
                a.appointment_time,
                a.reason,
                a.special_instructions,
                a.status,
                a.cancellation_reason,
                a.cancellation_details,
                a.tracking_number,
                a.created_at,
                a.updated_at,
                a.appointment_type,
                a.reference_number,
                a.guardian_name,
                a.guardian_relationship,
                a.insurance_verified,
                a.id_verified,
                a.forms_completed,
                a.checked_in_at,
                a.completed_at,
                a.last_visit,
                a.is_follow_up,
                p.first_name, p.last_name, p.middle_name, p.suffix, p.contact_number, 
                p.email, p.patient_reference_number, p.id as patient_id, p.profile,
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
            "$appointment->first_name " .
            ($appointment->middle_name ? "$appointment->middle_name " : '') .
            $appointment->last_name .
            ($appointment->suffix ? " $appointment->suffix" : '')
        );

        $appointment->formatted_date = date('M j, Y', strtotime($appointment->appointment_date));
        $appointment->formatted_time = date('g:i A', strtotime($appointment->appointment_time));
        $appointment->profile = $appointment->profile ?? 'default-avatar.jpg';
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
        // Update the current appointment
        $success = $this->update($appointmentId, array_merge(
            $additionalData,
            [
                'status' => 'completed',
                'completed_at' => date('Y-m-d H:i:s'),
                'last_visit' => date('Y-m-d'), // Add this line to update last_visit
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ));

        if ($success) {
            // Get the patient ID from the appointment
            $appointment = $this->getAppointmentById($appointmentId);
            if ($appointment) {
                // Update last_visit for all future appointments of this patient
                $this->db->query("UPDATE {$this->table} 
                    SET last_visit = :current_date 
                    WHERE patient_id = :patient_id 
                    AND appointment_date > :current_date");

                $this->db->bind(':current_date', date('Y-m-d'));
                $this->db->bind(':patient_id', $appointment->patient_id);
                $this->db->execute();
            }
        }

        return $success;
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
                p.profile AS patient_profile,
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

    /**
     * Get total number of unique patients assigned to a doctor
     * 
     * @param int $doctorId The doctor ID
     * @param bool $lastMonth Whether to get last month's count
     * @return int The total number of unique patients
     */
    public function getTotalAssignedPatientsByDoctorId($doctorId, $lastMonth = false)
    {
        $query = 'SELECT COUNT(DISTINCT patient_id) as total 
                 FROM appointments 
                 WHERE doctor_id = :doctor_id';

        if ($lastMonth) {
            $query .= ' AND MONTH(created_at) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))
                       AND YEAR(created_at) = YEAR(DATE_SUB(NOW(), INTERVAL 1 MONTH))';
        } else {
            $query .= ' AND MONTH(created_at) = MONTH(NOW())
                       AND YEAR(created_at) = YEAR(NOW())';
        }

        $this->db->query($query);
        $this->db->bind(':doctor_id', $doctorId);

        $result = $this->db->single();
        return $result ? $result->total : 0;
    }


    public function getTodayAppointmentsByDoctor($doctorId)
    {
        $sql = $this->buildBaseQuery(true) . "
            WHERE a.doctor_id = :doctor_id 
            AND DATE(a.appointment_date) = CURDATE()
            ORDER BY a.appointment_time ASC";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);

        $appointments = $this->db->resultSet();
        return [
            'total' => count($appointments),
            'appointments' => array_map([$this, 'formatAppointmentDetails'], $appointments)
        ];
    }

    public function getUpcomingAppointmentsByDoctor($doctorId)
    {
        $sql = $this->buildBaseQuery(true) . "
            WHERE a.doctor_id = :doctor_id 
            ORDER BY 
                CASE 
                    WHEN a.appointment_date = CURDATE() THEN 0
                    WHEN a.appointment_date > CURDATE() THEN 1
                    ELSE 2
                END,
                a.appointment_date ASC,
                a.appointment_time ASC";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);

        $appointments = $this->db->resultSet();
        return [
            'total' => count($appointments),
            'appointments' => array_map([$this, 'formatAppointmentDetails'], $appointments)
        ];
    }


    public function getPastAppointmentsByDoctor($doctorId)
    {
        $sql = $this->buildBaseQuery(true) . "
            WHERE a.doctor_id = :doctor_id
            AND (a.appointment_date < CURDATE() OR (a.appointment_date = CURDATE() AND a.status IN ('completed', 'no-show', 'cancelled')))
            ORDER BY a.appointment_date DESC, a.appointment_time DESC";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);

        $appointments = $this->db->resultSet();
        return [
            'total' => count($appointments),
            'appointments' => array_map([$this, 'formatAppointmentDetails'], $appointments)
        ];

    }


    public function getRecentVisitsByPatientsAssignedToDoctor($doctorId, $limit = 10)
    {
        $sql = "SELECT DISTINCT 
                a.*,
                p.first_name, p.last_name, p.middle_name, p.suffix,
                p.contact_number, p.email, p.profile,
                d.first_name as doctor_first_name, 
                d.last_name as doctor_last_name,
                d.specialization,
                prev.appointment_date as last_visit_date,
                prev_doc.first_name as previous_doctor_first_name,
                prev_doc.last_name as previous_doctor_last_name,
                prev_doc.specialization as previous_doctor_specialization
                FROM {$this->table} a
                JOIN patients p ON a.patient_id = p.id
                JOIN doctors d ON a.doctor_id = d.id
                LEFT JOIN {$this->table} prev ON a.patient_id = prev.patient_id 
                    AND prev.status = 'completed'
                    AND prev.appointment_date < a.appointment_date
                LEFT JOIN doctors prev_doc ON prev.doctor_id = prev_doc.id
                WHERE a.doctor_id = :doctor_id
                AND a.status NOT IN ('cancelled', 'no-show')
                ORDER BY prev.appointment_date DESC
                LIMIT :limit";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':limit', $limit);

        $visits = $this->db->resultSet();
        return array_map([$this, 'formatAppointmentDetails'], $visits);
    }


    public function getMonthlyVisitStats($doctorId)
    {
        $sql = "SELECT 
        DATE_FORMAT(appointment_date, '%b') as month,
        COUNT(*) as visit_count
        FROM appointments 
        WHERE doctor_id = :doctor_id 
        AND status = 'completed'
        AND appointment_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        GROUP BY MONTH(appointment_date)
        ORDER BY appointment_date ASC";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);

        $results = $this->db->resultSet();

        // Create array with all months (including zeros for months with no visits)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $visitData = array_fill_keys($months, 0);

        foreach ($results as $row) {
            if (isset($visitData[$row->month])) {
                $visitData[$row->month] = (int) $row->visit_count;
            }
        }

        return [
            'labels' => array_keys($visitData),
            'data' => array_values($visitData)
        ];
    }

    public function getAppointmentsByDoctorId($doctorId)
    {
        $sql = $this->buildBaseQuery(true) . "
            WHERE a.doctor_id = :doctor_id 
            ORDER BY 
                CASE 
                    WHEN a.appointment_date = CURDATE() THEN 0
                    WHEN a.appointment_date > CURDATE() THEN 1
                    ELSE 2
                END,
                a.appointment_date ASC,
                a.appointment_time ASC";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);

        $appointments = $this->db->resultSet();
        return array_map(function ($appointment) {
            $appointment = $this->formatAppointmentDetails($appointment);

            // Add additional formatted fields
            $appointment->patient_name = trim(
                $appointment->first_name . ' ' .
                ($appointment->middle_name ? $appointment->middle_name . ' ' : '') .
                $appointment->last_name .
                ($appointment->suffix ? ' ' . $appointment->suffix : '')
            );

            $appointment->doctor_name = trim(
                $appointment->doctor_first_name . ' ' .
                $appointment->doctor_last_name
            );

            $appointment->formatted_date = date('M d, Y', strtotime($appointment->appointment_date));
            $appointment->formatted_time = date('h:i A', strtotime($appointment->appointment_time));

            return $appointment;
        }, $appointments);
    }


}