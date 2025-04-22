<?php

namespace app\models;

use app\models\Model;

class TransactionRecord extends Model
{
    protected $table = 'transaction_records';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(): string
    {
        $fields = [
            't.id',
            't.medicine_id',
            't.transaction_type',
            't.quantity',
            't.unit_price',
            't.total_amount',
            't.transaction_date',
            't.staff_id',
            't.supplier',
            't.manufacturer',
            't.patient_id',
            't.prescription_id',
            't.payment_status',
            't.remarks',
            't.created_at',
            'm.name as medicine_name',
            'm.form as medicine_form',
            'm.dosage as medicine_dosage'
        ];
        return "SELECT " . implode(', ', $fields) . " 
                FROM {$this->table} t
                LEFT JOIN medicine_inventory m ON t.medicine_id = m.id";
    }

    public function createTransaction($data)
    {
        $this->db->query("INSERT INTO {$this->table} 
            (medicine_id, transaction_type, quantity, unit_price, total_amount, 
            transaction_date, staff_id, supplier, manufacturer, patient_id, prescription_id, 
            payment_status, remarks, created_at) 
            VALUES 
            (:medicine_id, :transaction_type, :quantity, :unit_price, :total_amount,
            :transaction_date, :staff_id, :supplier, :manufacturer, :patient_id, :prescription_id,
            :payment_status, :remarks, :created_at)");

        $this->db->bind(':medicine_id', $data['medicine_id']);
        $this->db->bind(':transaction_type', $data['transaction_type']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':unit_price', $data['unit_price']);
        $this->db->bind(':total_amount', $data['quantity'] * $data['unit_price']);
        $this->db->bind(':transaction_date', $data['transaction_date'] ?? date('Y-m-d H:i:s'));
        $this->db->bind(':staff_id', $data['staff_id']);
        $this->db->bind(':supplier', $data['supplier'] ?? null);
        $this->db->bind(':manufacturer', $data['manufacturer'] ?? null);
        $this->db->bind(':patient_id', $data['patient_id'] ?? null);
        $this->db->bind(':prescription_id', $data['prescription_id'] ?? null);
        $this->db->bind(':payment_status', $data['payment_status'] ?? 'completed');
        $this->db->bind(':remarks', $data['remarks'] ?? null);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));

        return $this->db->execute() ? $this->db->lastInsertId() : false;
    }

    public function getTransactionById($id)
    {
        $query = $this->buildBaseQuery() . " WHERE t.id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getMedicineTransactions($medicineId)
    {
        $query = $this->buildBaseQuery() . " WHERE t.medicine_id = :medicine_id ORDER BY t.transaction_date DESC";
        $this->db->query($query);
        $this->db->bind(':medicine_id', $medicineId);
        return $this->db->resultSet();
    }

    public function getTransactionsByDateRange($startDate, $endDate, $type = null)
    {
        $query = $this->buildBaseQuery() . " WHERE t.transaction_date BETWEEN :start_date AND :end_date";

        if ($type) {
            $query .= " AND t.transaction_type = :type";
        }

        $query .= " ORDER BY t.transaction_date DESC";

        $this->db->query($query);
        $this->db->bind(':start_date', $startDate);
        $this->db->bind(':end_date', $endDate);

        if ($type) {
            $this->db->bind(':type', $type);
        }

        return $this->db->resultSet();
    }

    public function getTransactionStats()
    {
        $this->db->query("SELECT 
            COUNT(*) as total_transactions,
            SUM(CASE WHEN transaction_type = 'purchase' THEN total_amount ELSE 0 END) as total_purchases,
            SUM(CASE WHEN transaction_type = 'dispense' THEN total_amount ELSE 0 END) as total_sales,
            COUNT(DISTINCT medicine_id) as unique_medicines
            FROM {$this->table}
            WHERE transaction_date >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)");

        return $this->db->single();
    }

    public function updateTransactionStatus($id, $status)
    {
        $this->db->query("UPDATE {$this->table} 
            SET payment_status = :status, updated_at = :updated_at 
            WHERE id = :id");

        $this->db->bind(':status', $status);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function getSupplierTransactions($supplierId)
    {
        $query = $this->buildBaseQuery() . " 
            WHERE t.supplier_id = :supplier_id 
            ORDER BY t.transaction_date DESC";

        $this->db->query($query);
        $this->db->bind(':supplier_id', $supplierId);
        return $this->db->resultSet();
    }

    public function getPatientTransactions($patientId)
    {
        $query = $this->buildBaseQuery() . " 
            WHERE t.patient_id = :patient_id 
            ORDER BY t.transaction_date DESC";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }

    public function getRecentTransactions($limit = 5)
    {
        $query = $this->buildBaseQuery() . " ORDER BY t.transaction_date DESC LIMIT 10";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getAllTransactionRecords()
    {
        $query = $this->buildBaseQuery();
        $this->db->query($query);
        return $this->db->resultSet();
    }
}