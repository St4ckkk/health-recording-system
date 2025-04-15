<?php

namespace app\models;

use app\models\Model;

class EPrescription extends Model {
    protected $table = 'e_prescription';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
           'pr.id',
           'pr.prescription_code',
           'pr.patient_id',
           'pr.doctor_id',
           'pr.vitals_id',
           'pr.diagnosis',
           'pr.advice',
           'pr.follow_up_date',
           'pr.created_at', 
        ]
    }


    
}