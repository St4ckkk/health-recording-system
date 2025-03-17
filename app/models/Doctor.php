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
        if ($status) {
            return $this->timeSlotModel->getDoctorsWithAvailabilityByStatus($status);
        } else {
            return $this->timeSlotModel->getDoctorsWithAvailability();
        }
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