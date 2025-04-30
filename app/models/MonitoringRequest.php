<?php

namespace app\models;

class MonitoringRequest extends Model
{
    protected $table = 'monitoring_requests';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (
            patient_id,
            doctor_id,
            token,
            status,
            expires_at
        ) VALUES (
            :patient_id,
            :doctor_id,
            :token,
            :status,
            :expires_at
        )";

        try {
            $this->db->query($sql);
            $this->db->bind(':patient_id', $data['patient_id']);
            $this->db->bind(':doctor_id', $data['doctor_id']);
            $this->db->bind(':token', $data['token']);
            $this->db->bind(':status', $data['status']);
            $this->db->bind(':expires_at', $data['expires_at']);

            if ($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (\PDOException $e) {
            error_log('MonitoringRequest create error: ' . $e->getMessage());
            return false;
        }
    }

    public function getByToken($token)
    {
        $query = "SELECT * FROM {$this->table} WHERE token = :token";
        $this->db->query($query);
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    public function updateStatus($id, $status, $completedAt = null)
    {
        $sql = "UPDATE {$this->table} SET 
                status = :status" .
            ($completedAt ? ", completed_at = :completed_at" : "") .
            " WHERE id = :id";

        try {
            $this->db->query($sql);
            $this->db->bind(':status', $status);
            $this->db->bind(':id', $id);
            if ($completedAt) {
                $this->db->bind(':completed_at', $completedAt);
            }
            return $this->db->execute();
        } catch (\PDOException $e) {
            error_log('MonitoringRequest update error: ' . $e->getMessage());
            return false;
        }
    }

    public function getActiveRequestsByPatient($patientId)
    {
        $query = "SELECT * FROM {$this->table} 
                 WHERE patient_id = :patient_id 
                 AND status IN ('pending', 'active')
                 AND expires_at > NOW()";

        $this->db->query($query);
        $this->db->bind(':patient_id', $patientId);
        return $this->db->resultSet();
    }

    public function validateMonitoringAccess($token)
    {
        $query = "SELECT mr.*, p.first_name, p.last_name, p.email, p.profile 
                  FROM {$this->table} mr 
                  JOIN patients p ON mr.patient_id = p.id 
                  WHERE mr.token = :token 
                  AND mr.status IN ('pending', 'active')
                  AND mr.expires_at > NOW()";

        $this->db->query($query);
        $this->db->bind(':token', $token);

        $result = $this->db->single();

        if ($result) {
            // Create patient session with required fields
            $_SESSION['patient'] = [
                'id' => $result->patient_id,
                'first_name' => $result->first_name ?? 'Unknown',
                'last_name' => $result->last_name ?? 'Patient',
                'email' => $result->email ?? '',
                'type' => 'monitoring_patient',
                'profile' => $result->profile ?? null,
                'monitoring_request_id' => $result->id,
                'expires_at' => $result->expires_at
            ];

            return [
                'success' => true,
                'data' => $result
            ];
        }

        // Clear any existing session if validation fails
        if (isset($_SESSION['patient'])) {
            unset($_SESSION['patient']);
        }

        return [
            'success' => false,
            'message' => 'Invalid or expired monitoring token'
        ];
    }

    public function checkMonitoringSession()
    {
        if (
            !isset($_SESSION['patient']) ||
            $_SESSION['patient']['type'] !== 'monitoring_patient' ||
            strtotime($_SESSION['patient']['expires_at']) < time()
        ) {

            if (isset($_SESSION['patient'])) {
                unset($_SESSION['patient']);
            }
            return false;
        }
        return true;
    }
}