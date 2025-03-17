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