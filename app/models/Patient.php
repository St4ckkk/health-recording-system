<?php

namespace app\models;

use app\models\Model;

class Patient extends Model
{
    protected $table = 'patients';

    public function __construct()
    {
        parent::__construct();
    }

    public function getPatientById($id)
    {
        // Using the inherited getById method instead of direct PDO
        return $this->getById($id);
    }

    // You could add more methods similar to the Doctor model
    public function getPatientByEmail($email)
    {
        return $this->getSingleByField('email', $email);
    }

    public function getFullName($patient)
    {
        $fullName = $patient->first_name;
        if (!empty($patient->middle_name)) {
            $fullName .= ' ' . $patient->middle_name;
        }
        $fullName .= ' ' . $patient->last_name;
        if (!empty($patient->suffix)) {
            $fullName .= ', ' . $patient->suffix;
        }
        return $fullName;
    }
}