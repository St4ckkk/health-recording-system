<?php

namespace app\controllers;

use app\models\Staff;
use app\core\Validator;

class SessionController extends Controller
{
    private $staffModel;

    public function __construct()
    {
        $this->staffModel = new Staff();
    }

    /**
     * Display login form
     */
    public function login()
    {
        // Check if already logged in
        if ($this->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process login form
            $this->processLogin();
            return;
        }

        // Display login form
        $this->view('pages/auth/login', [
            'title' => 'Login'
        ]);
    }

    /**
     * Process login form
     */
    private function processLogin()
    {
        $email = trim(htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'));
        $password = $_POST['password'] ?? '';

        $validator = new Validator([
            'email' => $email,
            'password' => $password
        ]);

        // Validate input
        $validator->required(['email', 'password'])
            ->email('email');

        // If validation fails, redisplay the form with errors
        if ($validator->fails()) {
            $this->view('pages/auth/login', [
                'title' => 'Login',
                'errors' => $validator->getErrors(),
                'email' => $email
            ]);
            return;
        }

        // Check if user exists
        $staff = $this->staffModel->authenticate($email, $password);

        if ($staff) {
            // Create session
            $this->createUserSession($staff);
            // Redirect based on role
            $this->redirectBasedOnRole();
        } else {
            // User login failed
            $errors = ['login' => 'Invalid email or password'];
            // If there are errors, redisplay the form
            if (!empty($errors)) {
                $this->view('pages/auth/login', [
                    'title' => 'Login',
                    'errors' => $errors,
                    'email' => $email
                ]);
                return;
            }
        }
    }

    /**
     * Create user session
     * 
     * @param object $staff The staff object
     */
    private function createUserSession($staff)
    {
        // Debug the staff object to see what fields are available
        error_log('Staff object: ' . print_r($staff, true));

        $_SESSION['staff_id'] = $staff->id;
        $_SESSION['staff_email'] = $staff->email;
        $_SESSION['staff_name'] = $staff->first_name . ' ' . $staff->last_name;
        $_SESSION['staff_role'] = $staff->role_name;

        // Store the entire staff object for easy access
        $_SESSION['staff'] = [
            'id' => $staff->id,
            'staff_id' => $staff->staff_id,
            'first_name' => $staff->first_name,
            'last_name' => $staff->last_name,
            'email' => $staff->email,
            'role_id' => $staff->role_id,
            'role_name' => $staff->role_name,
            'profile' => $staff->profile ?? null
        ];

        // Debug the session after setting it
        error_log('Session staff data set: ' . print_r($_SESSION['staff'], true));
    }

    /**
     * 
     * Redirect based on user role
     */
    private function redirectBasedOnRole()
    {
        $role = $_SESSION['staff_role'] ?? '';

        switch ($role) {
            case 'receptionist':
                $this->redirect('/receptionist/dashboard');
                break;
            case 'nurse':
                $this->redirect('/nurse/dashboard');
                break;
            case 'pharmacist':
                $this->redirect('/pharmacist/dashboard');
                break;
            default:
                $this->redirect('/');
                break;
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();

        // Redirect to login page
        $this->redirect('/login');
    }

    /**
     * Check if user is logged in
     * 
     * @return bool True if logged in, false otherwise
     */
    public function isLoggedIn()
    {
        return isset($_SESSION['staff_id']);
    }
}