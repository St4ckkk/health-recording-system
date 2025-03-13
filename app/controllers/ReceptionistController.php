<?php 

namespace app\controllers;

class ReceptionistController extends Controller {
    
    public function dashboard() {
        $this->view('pages/receptionist/dashboard', [
            'title' => 'Receptionist'
        ]);
    }

    public function appointments() {
        $this->view('pages/receptionist/appointments', [
            'title' => 'Appointments'
        ]);
    }

    public function notification() {
        $this->view('pages/receptionist/notification', [
            'title' => 'Notification'
        ]);
    }
}
