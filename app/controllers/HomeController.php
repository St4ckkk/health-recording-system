<?php

namespace app\controllers;

use app\models\Doctor;
use app\models\DoctorTimeSlot;

class HomeController extends Controller
{
    private $doctorModel;
    private $timeSlotModel;

    public function __construct()
    {
        // Initialize models in the constructor
        $this->doctorModel = new Doctor();
        $this->timeSlotModel = new DoctorTimeSlot();
    }

    public function index()
    {
        $this->view('index', [
            'title' => 'Health Recording System'
        ]);
    }

    public function appointment()
    {
        $doctors = $this->doctorModel->getAllDoctors();

        // Get unique specializations
        $specializations = [];
        if (!empty($doctors)) {
            $specializations = array_unique(array_column($doctors, 'specialization'));
        }

        $data = [
            'title' => 'Doctor Availability',
            'doctors' => $doctors,
            'specializations' => $specializations,
            'doctorModel' => $this->doctorModel,
            'timeSlotModel' => $this->timeSlotModel
        ];

        $this->view('pages/appointment/doctor-availability', $data);
    }

    public function scheduling()
    {
        $this->view('pages/appointment/scheduling', [
            'title' => 'Schedule Your Appointment'
        ]);
    }

    public function referral()
    {
        $this->view('pages/referral/referral', [
            'title' => 'Referral'
        ]);
    }


}