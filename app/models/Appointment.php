<?php

namespace app\models;

use app\models\Model;

class Appointment extends Model {
    protected $table = 'appointments';

    public function __construct() {
        parent::__construct();
    }

    public function getAppointmentByTrackingNumber($trackingNumber) {
        // Log the tracking number for debugging
        error_log("Looking for appointment with tracking number: " . $trackingNumber);
        
        // Validate tracking number
        if (empty($trackingNumber)) {
            error_log("Empty tracking number provided");
            return null;
        }
        
        // Trim the tracking number to remove any whitespace
        $trackingNumber = trim($trackingNumber);
        
        // Use getSingleByField method from parent Model class
        return $this->getSingleByField('tracking_number', $trackingNumber);
    }
    
    public function getLastError() {
        if ($this->db) {
            return $this->db->errorInfo();
        }
        return null;
    }
}