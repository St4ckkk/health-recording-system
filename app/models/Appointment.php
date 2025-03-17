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

   
    
    /**
     * 
     * 
     * @param int 
     * @param string 
     * @param int|null $
     * @return bool 
     */
    public function updateStatus($appointmentId, $status, $changedBy = null) {
        $sql = "UPDATE {$this->table} SET status = :status, updated_at = NOW() WHERE id = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
            $stmt->bindParam(':id', $appointmentId, \PDO::PARAM_INT);
            $success = $stmt->execute();
            
            if ($success) {
                $historyModel = new \app\models\AppointmentStatusHistory();
                return $historyModel->addStatusChange($appointmentId, $status, $changedBy);
            }
            
            return false;
        } catch (\PDOException $e) {
            error_log("Database error in updateStatus: " . $e->getMessage());
            return false;
        }
    }
}