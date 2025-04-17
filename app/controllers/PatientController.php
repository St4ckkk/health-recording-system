<?php

namespace app\controllers;



class PatientController extends Controller
{

    public function __construct()
    {
        
    }

    public function dashboard() {
        $this->view('pages/patient/dashboard.view', [
            'title' => 'Dashboard',
        ]);
    }



}