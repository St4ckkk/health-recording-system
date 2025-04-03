<?php

namespace app\models;

use app\models\Model;

class MedicineInventory extends Model
{
    protected $table = 'medicine_inventory';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string
    {
        $fields = [
            'm.id',
            'm.name',
            'm.category',
            'm.form',
            'm.dosage',
            'm.stock_level',
            'm.expiry_date',
            'm.status',
            'm.created_at',
            'm.updated_at'
        ];
        return "SELECT " . implode(', ', $fields) . " FROM {$this->table} m";
    }

    public function getAllMedicines()
    {
        $query = $this->buildBaseQuery();
        $this->db->query($query . " ORDER BY m.name ASC");
        return $this->db->resultSet();
    }


    public function getMedicineById($id)
    {
        $query = $this->buildBaseQuery() . " WHERE m.id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getLowStockMedicines($threshold = 10)
    {
        $query = $this->buildBaseQuery() . " WHERE m.stock_level <= :threshold";
        $this->db->query($query);
        $this->db->bind(':threshold', $threshold);
        return $this->db->resultSet();
    }

    public function getExpiringSoonMedicines($daysThreshold = 30)
    {
        $query = $this->buildBaseQuery() . " 
            WHERE m.expiry_date <= DATE_ADD(CURDATE(), INTERVAL :days DAY)
            AND m.expiry_date >= CURDATE()
            ORDER BY m.expiry_date ASC";
        $this->db->query($query);
        $this->db->bind(':days', $daysThreshold);
        return $this->db->resultSet();
    }

    public function insert($data)
    {
        $this->db->query("INSERT INTO {$this->table} 
            (name, category, form, dosage, stock_level, expiry_date, status, created_at, updated_at) 
            VALUES 
            (:name, :category, :form, :dosage, :stock_level, :expiry_date, :status, :created_at, :updated_at)");

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':form', $data['form']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':stock_level', $data['stock_level']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

        return $this->db->execute() ? $this->db->lastInsertId() : false;
    }

    public function updateStock($id, $newStockLevel)
    {
        $this->db->query("UPDATE {$this->table} 
            SET stock_level = :stock_level, updated_at = :updated_at 
            WHERE id = :id");

        $this->db->bind(':stock_level', $newStockLevel);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function getMedicineStats()
    {
        $this->db->query("SELECT 
            COUNT(*) as total_medicines,
            COUNT(CASE WHEN stock_level <= 10 THEN 1 END) as low_stock,
            COUNT(CASE WHEN expiry_date <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) 
                      AND expiry_date >= CURDATE() THEN 1 END) as expiring_soon
            FROM {$this->table}");

        return $this->db->single();
    }

    public function getLowStockCount()
    {
        $this->db->query("SELECT COUNT(*) as count, 
                GROUP_CONCAT(CONCAT(name, ' (', stock_level, ' remaining)') SEPARATOR ', ') as low_stock_items 
                FROM {$this->table} 
                WHERE status = 'Low Stock'");

        $result = $this->db->single();
        return [
            'count' => $result ? $result->count : 0,
            'items' => $result && $result->low_stock_items ? $result->low_stock_items : ''
        ];
    }

    public function getMedicineUsageStats()
    {
        $this->db->query("SELECT 
                m.category,
                COUNT(CASE WHEN ml.action_type = 'restock' THEN 1 END) as prescribed_count,
                COUNT(CASE WHEN ml.action_type = 'dispense' THEN 1 END) as dispensed_count
                FROM medicine_inventory m
                LEFT JOIN medicine_logs ml ON m.id = ml.medicine_id
                GROUP BY m.category
                ORDER BY prescribed_count DESC
                LIMIT 5");

        return $this->db->resultSet();
    }
}