<?php

namespace app\models;

use app\models\Model;

class EPrescriptionMedicinces extends Model {
    protected $table = 'e_prescription_medicines';

    public function __construct()
    {
        parent::__construct();
    }

    private function buildBaseQuery(bool $includeType = false): string {
        $fields = [
           'prmed.id',
           'prmed.e_prescription_id',
           'prmed.medicine_name',
           'prmed.dosage',
           'prmed.duration',
        ]
    }


    
}