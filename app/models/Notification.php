<?php

namespace app\models;

use app\models\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public function __construct()
    {
        parent::__construct();
    }

    public function getRecent($userId, $limit = 10)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = :user_id 
                ORDER BY created_at DESC 
                LIMIT :limit";

        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':limit', $limit);

        return $this->db->resultSet();
    }

    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} (user_id, title, message, type, priority, link) 
                VALUES (:user_id, :title, :message, :type, :priority, :link)";

        $this->db->query($sql);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':priority', $data['priority'] ?? 'medium');
        $this->db->bind(':link', $data['link'] ?? null);

        return $this->db->execute();
    }

    public function markAsRead($notificationId)
    {
        $sql = "UPDATE {$this->table} 
                SET status = 'read', read_at = NOW() 
                WHERE id = :id";

        $this->db->query($sql);
        $this->db->bind(':id', $notificationId);

        return $this->db->execute();
    }
}