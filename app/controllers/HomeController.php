<?php


namespace app\controllers;

class HomeController extends Controller {
    public function index() {
        $this->view('index', [
            'title' => 'Health Recording System'
        ]);
    }

    public function appointment() {
        $this->view('pages/appointment/doctor-availability', [
            'title' => 'Schedule Your Appointment'
        ]);
    }

    public function scheduling() {
        $this->view('pages/appointment/scheduling', [
            'title' => 'Schedule Your Appointment'
        ]);
    }

    public function referral() {
        $this->view('pages/referral/referral', [
            'title' => 'Referral'
        ]);
    }
}