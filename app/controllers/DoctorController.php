<?php

namespace app\controllers;

use app\models\Appointment;
use app\models\Doctor;
use app\models\DoctorTimeSlot;
use app\models\Patient;
use app\helpers\EmailHelper;
use app\helpers\TrackingNumber;

class DoctorController extends Controller {
    
    public function dashboard() {
        $this->view('pages/doctor/dashboard.view');
    }


    
}