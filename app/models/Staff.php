<?php

namespace app\models;

use app\models\Model;

class Staff extends Model
{
    protected $table = 'staff';

    public function __construct()
    {
        parent::__construct();
    }

    public function getStaffById($id)
    {
        return $this->getById($id);
    }

    public function getStaffByEmail($email)
    {
        return $this->getSingleByField('email', $email);
    }

    /**
     * Get staff with role information
     * 
     * @param int $id The staff ID
     * @return object|bool The staff object with role or false if not found
     */
    public function getStaffWithRole($id)
    {
        $this->db->query('SELECT s.*, r.role_name 
                         FROM staff s 
                         JOIN roles r ON s.role_id = r.id 
                         WHERE s.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Authenticate staff login
     * 
     * @param string $email The staff email
     * @param string $password The staff password
     * @return object|bool The staff object or false if authentication fails
     */
    public function authenticate($email, $password)
    {
        $staff = $this->getStaffByEmail($email);

        if (!$staff) {
            return false;
        }

        // For SHA256 hashed passwords
        if (hash('sha256', $password) === $staff->password) {
            // Get role information
            $this->db->query('SELECT r.role_name 
                             FROM roles r 
                             WHERE r.id = :role_id');
            $this->db->bind(':role_id', $staff->role_id);
            $role = $this->db->single();

            // Add role name to staff object
            $staff->role_name = $role ? $role->role_name : null;

            return $staff;
        }

        return false;
    }

    /**
     * Insert a new staff member
     * 
     * @param array $data The staff data
     * @return bool|int The ID of the inserted staff or false on failure
     */
    public function insert($data)
    {
        try {
            error_log("Staff::insert - Starting staff insertion");

            $this->db->query('INSERT INTO staff (
                staff_id,
                first_name,
                last_name,
                email,
                password,
                phone,
                profile_picture,
                role_id,
                created_at
            ) VALUES (
                :staff_id,
                :first_name,
                :last_name,
                :email,
                :password,
                :phone,
                :profile_picture,
                :role_id,
                :created_at
            )');

            // Bind values
            $this->db->bind(':staff_id', $data['staff_id']);
            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':last_name', $data['last_name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':phone', $data['phone'] ?? null);
            $this->db->bind(':profile_picture', $data['profile_picture'] ?? null);
            $this->db->bind(':role_id', $data['role_id']);
            $this->db->bind(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'));

            error_log("Staff::insert - All values bound, executing query");

            // Execute
            if ($this->db->execute()) {
                $staffId = $this->db->lastInsertId();
                error_log("Staff::insert - Staff inserted successfully with ID: $staffId");
                return $staffId;
            }

            return false;
        } catch (\Exception $e) {
            error_log("Staff::insert - Exception: " . $e->getMessage());
            error_log("Staff::insert - Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    /**
     * Update a staff member
     * 
     * @param int $id The staff ID
     * @param array $data The staff data
     * @return bool True on success, false on failure
     */
    public function update($id, $data)
    {
        $this->db->query('UPDATE staff SET
            first_name = :first_name,
            last_name = :last_name,
            email = :email,
            phone = :phone,
            profile_picture = :profile_picture,
            role_id = :role_id,
            updated_at = :updated_at
        WHERE id = :id');

        // Bind values
        $this->db->bind(':id', $id);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone'] ?? null);
        $this->db->bind(':profile_picture', $data['profile_picture'] ?? null);
        $this->db->bind(':role_id', $data['role_id']);
        $this->db->bind(':updated_at', $data['updated_at'] ?? date('Y-m-d H:i:s'));

        // Execute
        return $this->db->execute();
    }

    /**
     * Get all staff members
     * 
     * @return array The staff members
     */
    public function getAllStaff()
    {
        $this->db->query('SELECT s.*, r.role_name 
                         FROM staff s 
                         JOIN roles r ON s.role_id = r.id 
                         ORDER BY s.last_name, s.first_name');
        return $this->db->resultSet();
    }
}