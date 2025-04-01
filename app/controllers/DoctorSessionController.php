<?php

namespace app\controllers;

use app\models\Doctor;
use app\core\Validator;

class DoctorSessionController extends Controller
{
    private $doctorModel;

    public function __construct()
    {
        $this->doctorModel = new Doctor();
    }

    public function login()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/doctor/dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
            return;
        }

        $this->view('pages/auth/doctor', [
            'title' => 'Doctor Login'
        ]);
    }

    private function processLogin()
    {
        $email = trim(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'));
        $password = $_POST['password'] ?? '';

        $validator = new Validator([
            'email' => $email,
            'password' => $password
        ]);

        $validator->required(['email', 'password'])
            ->email('email');

        if ($validator->fails()) {
            $this->view('pages/auth/doctor', [
                'title' => 'Doctor Login',
                'errors' => $validator->getErrors(),
                'email' => $email
            ]);
            return;
        }

        // Replace the existing authentication logic with authenticate method
        $doctor = $this->doctorModel->authenticate($email, $password);

        if ($doctor) {
            $this->createDoctorSession($doctor);
            $this->redirect('/doctor/dashboard');
            return;
        }

        $errors = ['login' => 'Invalid email or password'];
        $this->view('pages/auth/doctor', [
            'title' => 'Doctor Login',
            'errors' => $errors,
            'email' => $email
        ]);
    }

    private function createDoctorSession($doctor)
    {
        $_SESSION['doctor_id'] = $doctor->id;
        $_SESSION['doctor_email'] = $doctor->email;
        $_SESSION['doctor_name'] = $doctor->first_name . ' ' . $doctor->last_name;
        $_SESSION['role'] = 'doctor';

        $_SESSION['doctor'] = [
            'id' => $doctor->id,
            'doctor_id' => $doctor->doctor_id,
            'first_name' => $doctor->first_name,
            'last_name' => $doctor->last_name,
            'middle_name' => $doctor->middle_name,
            'suffix' => $doctor->suffix,
            'contact_number' => $doctor->contact_number,
            'email' => $doctor->email,
            'specialization' => $doctor->specialization,
            'max_appointments_per_day' => $doctor->max_appointments_per_day,
            'status' => $doctor->status,
            'default_location' => $doctor->default_location,
            'profile' => $doctor->profile ?? null,
            'work_hours_start' => $doctor->work_hours_start,
            'work_hours_end' => $doctor->work_hours_end,
            'role_id' => $doctor->role_id
        ];
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect('/auth/doctor');
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['doctor_id']);
    }
}