<?php

namespace app\models;

use app\models\Model;
use app\models\DoctorTimeSlot;
use app\models\Appointment;

class Doctor extends Model
{
    protected $table = 'doctors';
    private $timeSlotModel;

    public function __construct()
    {
        parent::__construct();
        $this->timeSlotModel = new DoctorTimeSlot();
    }

    public function getAllDoctors($status = null)
    {
        return $this->timeSlotModel->getDoctorsWithAvailability($status);
    }

    public function getDoctorById($id)
    {
        $this->db->query("SELECT * FROM doctors WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getDoctorsByStatus($status)
    {
        return $this->getByField('status', $status);
    }

    public function getDoctorByEmail($email)
    {
        return $this->getSingleByField('email', $email);
    }

    /**
     * Authenticate doctor login
     * 
     * @param string $email The doctor email
     * @param string $password The doctor password
     * @return object|bool The doctor object or false if authentication fails
     */
    public function authenticate($email, $password)
    {
        $doctor = $this->getDoctorByEmail($email);

        if (!$doctor) {
            return false;
        }

        // For SHA256 hashed passwords
        if (hash('sha256', $password) === $doctor->password) {
            return $doctor;
        }

        return false;
    }

    /**
     * Get doctor's full name
     */
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

    public function insert($data)
    {
        $this->db->query('INSERT INTO doctors (
            first_name, 
            last_name, 
            middle_name, 
            suffix, 
            specialization, 
            license_number,
            contact_number, 
            email, 
            max_appointments_per_day,    
            status, 
            default_location, 
            profile, 
            created_at,
            work_hours_start,
            work_hours_end
        ) VALUES (
            :first_name, 
            :last_name, 
            :middle_name, 
            :suffix, 
            :specialization, 
            :license_number,  
            :contact_number, 
            :email, 
            :max_appointments_per_day, 
            :status, 
            :default_location, 
            :profile, 
            :created_at,
            :work_hours_start,
            :work_hours_end
        )');

        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':middle_name', $data['middle_name']);
        $this->db->bind(':suffix', $data['suffix']);
        $this->db->bind(':specialization', $data['specialization']);
        $this->db->bind(':license_number', $data['license_number']);
        $this->db->bind(':contact_number', $data['contact_number']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':max_appointments_per_day', $data['max_appointments_per_day']);
        $this->db->bind(':default_location', $data['default_location']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':profile', $data['profile']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':work_hours_start', $data['work_hours_start']);
        $this->db->bind(':work_hours_end', $data['work_hours_end']);

        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Get doctor schedule with time slots
     * 
     * @param int $doctorId The doctor ID
     * @return object|null The doctor with schedule information
     */
    public function getDoctorSchedule($doctorId)
    {
        // Get doctor details
        $doctor = $this->getDoctorById($doctorId);

        if (!$doctor) {
            return null;
        }

        // Add full name
        $doctor->full_name = $this->getFullName($doctor);

        // Get available days
        $doctor->available_days = $this->timeSlotModel->getDoctorAvailableDays($doctorId);

        // Get time slots
        $doctor->time_slots = $this->timeSlotModel->getTimeSlotsByDoctorId($doctorId);

        return $doctor;
    }

    /**
     * Get doctor's upcoming appointments
     * 
     * @param int $doctorId The doctor ID
     * @param int $limit Optional limit of appointments to return
     * @return array The upcoming appointments
     */
    public function getDoctorUpcomingAppointments($doctorId, $limit = 10)
    {
        $appointmentModel = new Appointment();
        return $appointmentModel->getUpcomingAppointmentsByDoctorId($doctorId, $limit);
    }


    public function getTotalPatientCount($doctorId)
    {
        $appointmentModel = new Appointment();
        return $appointmentModel->getTotalAssignedPatientsByDoctorId($doctorId);
    }

    /**
     * Get patient count percentage change from last month
     * 
     * @param int $doctorId The doctor ID
     * @return array Contains total count and percentage change
     */
    public function getPatientCountChange($doctorId)
    {
        $appointmentModel = new Appointment();

        // Get current month's count
        $currentCount = $appointmentModel->getTotalAssignedPatientsByDoctorId($doctorId);

        // Get last month's count
        $lastMonthCount = $appointmentModel->getTotalAssignedPatientsByDoctorId($doctorId, true);

        // Calculate percentage change
        $percentageChange = 0;
        if ($lastMonthCount > 0) {
            $percentageChange = (($currentCount - $lastMonthCount) / $lastMonthCount) * 100;
        }

        return [
            'total' => $currentCount,
            'percentage' => round($percentageChange, 1)
        ];
    }

    public function getTodayAppointments($doctorId)
    {
        $appointmentModel = new Appointment();
        return $appointmentModel->getTodayAppointmentsByDoctor($doctorId);
    }

    public function getPatientsByDoctor($doctorId)
    {
        $sql = "SELECT DISTINCT 
                p.*,
                (SELECT last_visit 
                 FROM appointments a2 
                 WHERE a2.patient_id = p.id 
                 AND a2.doctor_id = :doctor_id 
                 ORDER BY a2.last_visit DESC 
                 LIMIT 1) as last_visit
                FROM patients p
                INNER JOIN appointments a ON p.id = a.patient_id
                WHERE a.doctor_id = :doctor_id
                ORDER BY p.last_name, p.first_name";

        $this->db->query($sql);
        $this->db->bind(':doctor_id', $doctorId);
        return $this->db->resultSet();
    }

    public function getTotalDoctorCount()
    {
        $sql = "SELECT COUNT(*) as total_doctors FROM doctors";
        $this->db->query($sql);
        $result = $this->db->single();
        return $result ? $result->total_doctors : 0;
    }

    public function getDoctorCountBySpecialization()
    {
        $sql = "SELECT specialization, COUNT(*) as doctor_count
                FROM doctors
                GROUP BY specialization";
        $this->db->query($sql);
        return $this->db->resultSet();
    }
}

