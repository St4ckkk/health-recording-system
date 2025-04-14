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
            'm.supplier',
            'm.manufacturer',
            'm.created_at',
            'm.updated_at'
        ];
        return "SELECT " . implode(', ', $fields) . " FROM {$this->table} m";
    }

    public function updateMed($data)
    {
        $this->db->query("UPDATE {$this->table} SET 
            name = :name,
            category = :category,
            form = :form,
            dosage = :dosage,
            stock_level = :stock_level,
            expiry_date = :expiry_date,
            supplier = :supplier,
            manufacturer = :manufacturer,
            updated_at = :updated_at
            WHERE id = :id");

        $this->db->bind(':id', $data['medicineId']);
        $this->db->bind(':name', $data['medicineName']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':form', $data['form']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':stock_level', $data['stockLevel']);
        $this->db->bind(':expiry_date', $data['expiryDate']);
        $this->db->bind(':supplier', $data['supplier']);
        $this->db->bind(':manufacturer', $data['manufacturer']);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

        return $this->db->execute();
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
            (name, category, form, dosage, stock_level, expiry_date, status, supplier, manufacturer, created_at, updated_at) 
            VALUES 
            (:name, :category, :form, :dosage, :stock_level, :expiry_date, :status, :supplier, :manufacturer, :created_at, :updated_at)");

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':form', $data['form']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':stock_level', $data['stock_level']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':supplier', $data['supplier']);
        $this->db->bind(':manufacturer', $data['manufacturer']);
        $this->db->bind(':created_at', date('Y-m-d H:i:s'));
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));

        return $this->db->execute() ? $this->db->lastInsertId() : false;
    }

    public function delete($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
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
        $this->db->query("SELECT 
            COUNT(*) as count,
            SUM(CASE WHEN stock_level = 0 THEN 1 ELSE 0 END) as out_of_stock_count,
            GROUP_CONCAT(
                CASE 
                    WHEN stock_level = 0 THEN CONCAT(name, ' (Out of Stock)')
                    ELSE CONCAT(name, ' (', stock_level, ' remaining)')
                END 
                SEPARATOR ', '
            ) as low_stock_items 
            FROM {$this->table} 
            WHERE status = 'Low Stock' OR stock_level = 0");

        $result = $this->db->single();
        return [
            'count' => $result ? $result->count : 0,
            'out_of_stock' => $result ? $result->out_of_stock_count : 0,
            'items' => $result && $result->low_stock_items ? $result->low_stock_items : ''
        ];
    }

    public function getMonthlyUsageStats()
    {
        $this->db->query("SELECT 
            MONTH(ml.created_at) as month,
            SUM(CASE WHEN ml.action_type = 'dispense' THEN ml.quantity ELSE 0 END) as dispensed,
            SUM(CASE WHEN ml.action_type = 'restock' THEN ml.quantity ELSE 0 END) as restocked
            FROM medicine_logs ml
            WHERE YEAR(ml.created_at) = YEAR(CURRENT_DATE)
            GROUP BY MONTH(ml.created_at)
            ORDER BY month ASC");

        return $this->db->resultSet();
    }

    public function getMedicineUsageStats()
    {
        $this->db->query("SELECT 
                m.category,
                CASE 
                    WHEN ml.doctor_id IS NOT NULL THEN CONCAT('Dr. ', d.first_name, ' ', d.last_name)
                    WHEN ml.staff_id IS NOT NULL THEN CONCAT(s.first_name, ' ', s.last_name)
                END as dispenser_name,
                CASE 
                    WHEN ml.doctor_id IS NOT NULL THEN 'Doctor'
                    WHEN ml.staff_id IS NOT NULL THEN r.role_name
                END as role,
                COUNT(ml.id) as dispensed_count,
                SUM(ml.quantity) as total_dispensed
                FROM {$this->table} m
                LEFT JOIN medicine_logs ml ON m.id = ml.medicine_id
                LEFT JOIN staff s ON ml.staff_id = s.id
                LEFT JOIN doctors d ON ml.doctor_id = d.id
                LEFT JOIN roles r ON s.role_id = r.id
                WHERE ml.action_type = 'dispense'
                GROUP BY m.category, COALESCE(ml.doctor_id, ml.staff_id)
                ORDER BY total_dispensed DESC
                LIMIT 5");

        return $this->db->resultSet();
    }




    public function getAllMedicineCategories()
    {
        $this->db->query("SELECT DISTINCT category FROM {$this->table} WHERE category IS NOT NULL AND category != '' ORDER BY category ASC");
        $results = $this->db->resultSet();

        // Extract just the category names from the result objects
        $categories = [];
        foreach ($results as $result) {
            $categories[] = $result->category;
        }

        return $categories;
    }

    public function searchMedicines($category = '', $searchTerm = '')
    {
        $query = $this->buildBaseQuery();
        $conditions = [];
        $params = [];


        if (!empty($category)) {
            $conditions[] = "m.category = :category";
            $params[':category'] = $category;
        }


        if (!empty($searchTerm)) {
            $conditions[] = "(m.name LIKE :search OR m.dosage LIKE :search OR m.form LIKE :search)";
            $params[':search'] = "%{$searchTerm}%";
        }


        $conditions[] = "m.status = 'Available'";


        $conditions[] = "m.stock_level > 0";


        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        // Add ordering
        $query .= " ORDER BY m.name ASC";

        $this->db->query($query);

        foreach ($params as $param => $value) {
            $this->db->bind($param, $value);
        }

        return $this->db->resultSet();
    }




    public function updateStockLevel($id, $newStockLevel)
    {
        $this->db->query("UPDATE {$this->table} SET stock_level = :stock_level, updated_at = :updated_at WHERE id = :id");
        $this->db->bind(':stock_level', $newStockLevel);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }


}