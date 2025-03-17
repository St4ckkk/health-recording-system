<?php

namespace app\models;

use app\models\Model;

class Patient extends Model {
    protected $table = 'patients';

    public function __construct() {
        parent::__construct();
    }

    public function getPatientById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}