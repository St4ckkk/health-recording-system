<?php

namespace app\models;

use app\models\Model;

class BillingRecords extends Model
{
    protected $table = 'billing_records';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAppointmentFee($appointmentType)
    {
        $fees = [
            'checkup' => 500.00,
            'follow_up' => 800.00,
            'consultation' => 1000.00,
            'treatment' => 1500.00,
            'emergency' => 2000.00,
            'vaccination' => 1200.00,
            'laboratory_test' => 1800.00
        ];

        return $fees[strtolower($appointmentType)] ?? 1000.00;
    }

    public function createAppointmentBilling($data)
    {
        try {
            // Get fee based on appointment type if not specified
            if (!isset($data['amount']) && isset($data['appointment_type'])) {
                $data['amount'] = $this->getAppointmentFee($data['appointment_type']);
            }

            $sql = "INSERT INTO {$this->table} (
                appointment_id,
                patient_id,
                staff_id,
                service_type,
                description,
                amount,
                status,
                due_date,
                billing_date,
                notes,
                created_at,
                updated_at
            ) VALUES (
                :appointment_id,
                :patient_id,
                :staff_id,
                :service_type,
                :description,
                :amount,
                :status,
                :due_date,
                :billing_date,
                :notes,
                NOW(),
                NOW()
            )";

            $this->db->query($sql);
            $this->db->bind(':appointment_id', $data['appointment_id']);
            $this->db->bind(':patient_id', $data['patient_id']);
            $this->db->bind(':staff_id', $data['staff_id']);
            $this->db->bind(':service_type', 'Appointment');
            $this->db->bind(':description', $data['description'] ?? 'Medical Consultation');
            $this->db->bind(':amount', $data['amount']);
            $this->db->bind(':status', $data['status'] ?? 'Pending');
            $this->db->bind(':due_date', $data['due_date'] ?? date('Y-m-d', strtotime('+30 days')));
            $this->db->bind(':billing_date', $data['billing_date'] ?? date('Y-m-d'));
            $this->db->bind(':notes', $data['notes'] ?? null);

            return $this->db->execute() ? $this->db->lastInsertId() : false;
        } catch (\PDOException $e) {
            error_log('Billing Record Creation Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getBillingsByAppointmentId($appointmentId)
    {
        $sql = "SELECT br.*, 
                p.first_name as patient_first_name, 
                p.last_name as patient_last_name,
                s.first_name as staff_first_name, 
                s.last_name as staff_last_name,
                a.appointment_date,
                a.appointment_time
                FROM {$this->table} br
                LEFT JOIN appointments a ON br.appointment_id = a.id
                LEFT JOIN patients p ON br.patient_id = p.id
                LEFT JOIN staff s ON br.staff_id = s.id
                WHERE br.appointment_id = :appointment_id";

        $this->db->query($sql);
        $this->db->bind(':appointment_id', $appointmentId);
        return $this->db->resultSet();
    }

    public function getPatientBillingHistory($patientId)
    {
        $sql = "SELECT br.*, 
                a.appointment_date,
                a.appointment_time,
                s.first_name as staff_first_name, 
                s.last_name as staff_last_name,
                s.role_id
                FROM {$this->table} br
                LEFT JOIN appointments a ON br.appointment_id = a.id
                LEFT JOIN staff s ON br.staff_id = s.id
                WHERE br.patient_id = :patient_id
                ORDER BY br.billing_date DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }

    public function updateBillingStatus($billingId, $status, $notes = null)
    {
        $sql = "UPDATE {$this->table} SET 
                status = :status,
                notes = :notes,
                updated_at = NOW()
                WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $billingId);
        $this->db->bind(':status', $status);
        $this->db->bind(':notes', $notes);
        return $this->db->execute();
    }

    public function getBillingById($billingId)
    {
        $sql = "SELECT br.*, 
                p.first_name as patient_first_name, 
                p.last_name as patient_last_name,
                s.first_name as staff_first_name, 
                s.last_name as staff_last_name,
                s.role_id,
                a.appointment_date,
                a.appointment_time
                FROM {$this->table} br
                LEFT JOIN appointments a ON br.appointment_id = a.id
                LEFT JOIN patients p ON br.patient_id = p.id
                LEFT JOIN staff s ON br.staff_id = s.id
                WHERE br.id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $billingId);
        return $this->db->single();
    }

    public function getStaffBillingStats($staffId)
    {
        $sql = "SELECT 
                COUNT(*) as total_billings,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_count,
                SUM(amount) as total_amount,
                SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as paid_amount
                FROM {$this->table}
                WHERE staff_id = :staff_id";

        $this->db->query($sql);
        $this->db->bind(':staff_id', $staffId);
        return $this->db->single();
    }


    public function getBillingStats()
    {
        $sql = "SELECT 
                COUNT(*) as total_billings,
                SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_count,
                SUM(amount) as total_amount,
                SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as paid_amount
                FROM {$this->table}";

        $this->db->query($sql);
        return $this->db->single();
    }

    public function getRecentBillings($limit = 5)
    {
        $sql = "SELECT br.*,
                p.first_name as patient_first_name,
                p.last_name as patient_last_name,
                s.first_name as staff_first_name,
                s.last_name as staff_last_name,
                a.appointment_date,
                a.appointment_time
                FROM {$this->table} br
                LEFT JOIN appointments a ON br.appointment_id = a.id
                LEFT JOIN patients p ON br.patient_id = p.id
                LEFT JOIN staff s ON br.staff_id = s.id
                ORDER BY br.billing_date DESC
                LIMIT 10";

        $this->db->query($sql);
        return $this->db->resultSet();
    }


    public function getAllBillingRecordsWithDetails()
    {
        try {
            $sql = "SELECT br.*, 
                    p.first_name as patient_first_name, 
                    p.last_name as patient_last_name,
                    s.first_name as staff_first_name, 
                    s.last_name as staff_last_name,
                    a.appointment_date,
                    a.appointment_time
                    FROM {$this->table} br
                    LEFT JOIN appointments a ON br.appointment_id = a.id
                    LEFT JOIN patients p ON br.patient_id = p.id
                    LEFT JOIN staff s ON br.staff_id = s.id
                    ORDER BY br.billing_date DESC";

            $this->db->query($sql);
            return $this->db->resultSet();
        } catch (\PDOException $e) {
            error_log('Error in getAllBillingRecordsWithDetails: ' . $e->getMessage());
            return [];
        }
    }

    public function getBillingDetailsById($id)
    {
        $sql = "SELECT br.*, 
                p.first_name as patient_first_name, 
                p.last_name as patient_last_name,
                s.first_name as staff_first_name, 
                s.last_name as staff_last_name,
                a.appointment_date,
                a.appointment_time
                FROM {$this->table} br
                LEFT JOIN appointments a ON br.appointment_id = a.id
                LEFT JOIN patients p ON br.patient_id = p.id
                LEFT JOIN staff s ON br.staff_id = s.id
                WHERE br.id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }



    // public function updateBillingStatus($id, $status)
    // {
    //     try {
    //         $sql = "UPDATE {$this->table} 
    //                 SET status = :status, updated_at = NOW() 
    //                 WHERE id = :id";

    //         $this->db->query($sql);
    //         $this->db->bind(':id', $id);
    //         $this->db->bind(':status', $status);

    //         return $this->db->execute();
    //     } catch (\PDOException $e) {
    //         error_log('Error in updateBillingStatus: ' . $e->getMessage());
    //         throw new \Exception('Database error: ' . $e->getMessage());
    //     }
    // }

}