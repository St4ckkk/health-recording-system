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
            'm.unit_price',
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
            unit_price = :unit_price,
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
        $this->db->bind(':unit_price', $data['unitPrice']);
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
            (name, category, form, dosage, stock_level, expiry_date, status, supplier, unit_price, manufacturer,created_at, updated_at) 
            VALUES 
            (:name, :category, :form, :dosage, :stock_level, :expiry_date, :status, :supplier, :unit_price, :manufacturer, :created_at, :updated_at)");

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':form', $data['form']);
        $this->db->bind(':dosage', $data['dosage']);
        $this->db->bind(':stock_level', $data['stock_level']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        $this->db->bind(':status', $data['status'] ?? 'active');
        $this->db->bind(':supplier', $data['supplier']);
        $this->db->bind(':unit_price', $data['unit_price'] ?? 0.00);
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

    // ... existing code ...

    public function getDoctorMedicineUsageStats($doctorId)
    {
        // Get most prescribed medicines
        $topMedicinesSql = "SELECT 
                                mi.id,
                                mi.name,
                                mi.category,
                                mi.form,
                                mi.dosage,
                                COUNT(ml.id) as prescription_count,
                                SUM(ml.quantity) as total_quantity
                            FROM medicine_logs ml
                            JOIN {$this->table} mi ON ml.medicine_id = mi.id
                            WHERE ml.doctor_id = :doctor_id
                            AND ml.action_type = 'Prescribed'
                            GROUP BY mi.id, mi.name, mi.category, mi.form, mi.dosage
                            ORDER BY prescription_count DESC
                            LIMIT 10";

        $this->db->query($topMedicinesSql);
        $this->db->bind(':doctor_id', $doctorId);
        $topMedicines = $this->db->resultSet();

        // Get medicine usage by category
        $categorySql = "SELECT 
                            mi.category,
                            COUNT(ml.id) as prescription_count,
                            SUM(ml.quantity) as total_quantity,
                            COUNT(DISTINCT ml.patient_id) as patient_count
                        FROM medicine_logs ml
                        JOIN {$this->table} mi ON ml.medicine_id = mi.id
                        WHERE ml.doctor_id = :doctor_id
                        AND ml.action_type = 'Prescribed'
                        GROUP BY mi.category
                        ORDER BY prescription_count DESC";

        $this->db->query($categorySql);
        $this->db->bind(':doctor_id', $doctorId);
        $categoryStats = $this->db->resultSet();

        // Get monthly prescription trends
        $monthlySql = "SELECT 
                            DATE_FORMAT(ml.created_at, '%Y-%m') as month,
                            COUNT(ml.id) as prescription_count,
                            COUNT(DISTINCT ml.patient_id) as patient_count,
                            COUNT(DISTINCT ml.medicine_id) as medicine_count
                        FROM medicine_logs ml
                        WHERE ml.doctor_id = :doctor_id
                        AND ml.action_type = 'Prescribed'
                        AND ml.created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 12 MONTH) AND CURDATE()
                        GROUP BY DATE_FORMAT(ml.created_at, '%Y-%m')
                        ORDER BY month ASC";

        $this->db->query($monthlySql);
        $this->db->bind(':doctor_id', $doctorId);
        $monthlyStats = $this->db->resultSet();

        // Get summary statistics
        $summarySql = "SELECT 
                            COUNT(ml.id) as total_prescriptions,
                            COUNT(DISTINCT ml.patient_id) as total_patients,
                            COUNT(DISTINCT ml.medicine_id) as total_medicines,
                            SUM(ml.quantity) as total_quantity,
                            ROUND(SUM(ml.quantity) / COUNT(ml.id), 2) as avg_quantity_per_prescription,
                            ROUND(COUNT(ml.id) / COUNT(DISTINCT ml.patient_id), 2) as avg_prescriptions_per_patient
                        FROM medicine_logs ml
                        WHERE ml.doctor_id = :doctor_id
                        AND ml.action_type = 'Prescribed'
                        AND ml.created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND CURDATE()";

        $this->db->query($summarySql);
        $this->db->bind(':doctor_id', $doctorId);
        $summaryStats = $this->db->single();

        return [
            'top_medicines' => $topMedicines,
            'by_category' => $categoryStats,
            'monthly_trends' => $monthlyStats,
            'summary' => $summaryStats
        ];
    }

    // ... existing code ...




    public function updateStockLevel($id, $newStockLevel)
    {
        $this->db->query("UPDATE {$this->table} SET stock_level = :stock_level, updated_at = :updated_at WHERE id = :id");
        $this->db->bind(':stock_level', $newStockLevel);
        $this->db->bind(':updated_at', date('Y-m-d H:i:s'));
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getTopMedicinesByStock($limit = 10)
    {
        $query = $this->buildBaseQuery() . " 
            ORDER BY m.stock_level DESC 
            LIMIT :limit";
        $this->db->query($query);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }


    public function getExpiringMedicineDetails($daysThreshold = 30)
    {
        $query = $this->buildBaseQuery() . " 
        WHERE m.expiry_date <= DATE_ADD(CURDATE(), INTERVAL :days DAY)
        AND m.expiry_date >= CURDATE()
        ORDER BY m.expiry_date ASC
        LIMIT 5";
        $this->db->query($query);
        $this->db->bind(':days', $daysThreshold);
        return $this->db->resultSet();
    }

    public function getCategoryDistribution()
    {
        $this->db->query("SELECT 
        category, 
        COUNT(*) as count,
        SUM(stock_level) as total_stock,
        SUM(unit_price * stock_level) as inventory_value
        FROM {$this->table}
        WHERE category IS NOT NULL AND category != ''
        GROUP BY category
        ORDER BY count DESC");
        return $this->db->resultSet();
    }

    public function getInventoryValueStats()
    {
        $this->db->query("SELECT 
        SUM(stock_level * unit_price) as total_value,
        AVG(unit_price) as average_price,
        MAX(unit_price) as max_price,
        MIN(CASE WHEN unit_price > 0 THEN unit_price ELSE NULL END) as min_price
        FROM {$this->table}
        WHERE stock_level > 0");
        return $this->db->single();
    }

    public function getRecentTransactions($limit = 5)
    {
        $this->db->query("SELECT 
        ml.id,
        m.name as medicine_name,
        ml.action_type,
        ml.quantity,
        ml.previous_stock,
        ml.new_stock,
        CASE 
            WHEN ml.doctor_id IS NOT NULL THEN CONCAT('Dr. ', d.first_name, ' ', d.last_name)
            WHEN ml.staff_id IS NOT NULL THEN CONCAT(s.first_name, ' ', s.last_name)
            ELSE 'System'
        END as performed_by,
        ml.created_at
        FROM medicine_logs ml
        JOIN {$this->table} m ON ml.medicine_id = m.id
        LEFT JOIN staff s ON ml.staff_id = s.id
        LEFT JOIN doctors d ON ml.doctor_id = d.id
        ORDER BY ml.created_at DESC
        LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }


}


// Add these new methods to the MedicineInventory class
