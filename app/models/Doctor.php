<?php

namespace app\models;

use app\models\Model;
use app\models\DoctorTimeSlot;

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
        return $this->getById($id);
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
     * Get doctor's full name
     * 
     * @param object $doctor The doctor object
     * @return string The full name
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
        $this->db->bind(':contact_number', $data['contact_number']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':max_appointments_per_day', $data['max_appointments_per_day']);
        $this->db->bind(':default_location', $data['default_location']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':profile', $data['profile_image']);
        $this->db->bind(':created_at', $data['created_at']);
        $this->db->bind(':work_hours_start', $data['work_hours_start']);
        $this->db->bind(':work_hours_end', $data['work_hours_end']);

        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
}