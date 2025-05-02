<?php

namespace app\models;

use app\models\Model;

class Achievement extends Model
{
    protected $table = 'achievements';

    public function __construct()
    {
        parent::__construct();
    }

    public function getPatientAchievements($patientId)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE patient_id = :patient_id 
                ORDER BY achieved_at DESC";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $patientId);

        return $this->db->resultSet();
    }

    public function awardAchievement($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (patient_id, title, description, badge_icon, achieved_at, category, points) 
                VALUES 
                (:patient_id, :title, :description, :badge_icon, :achieved_at, :category, :points)";

        $this->db->query($sql);
        $this->db->bind(':patient_id', $data['patient_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':badge_icon', $data['badge_icon']);
        $this->db->bind(':achieved_at', date('Y-m-d H:i:s'));
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':points', $data['points']);

        return $this->db->execute();
    }
}