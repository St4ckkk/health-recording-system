<?php

namespace app\models;

use app\models\Model;

class DoctorTimeSlot extends Model
{
    protected $table = 'doctor_time_slots';

    public function __construct()
    {
        parent::__construct();
    }

    public function getTimeSlotsByDoctorId($doctorId)
    {
        $this->db->query('SELECT * FROM doctor_time_slots WHERE doctor_id = :doctor_id ORDER BY FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"), start_time ASC');
        $this->db->bind(':doctor_id', $doctorId);
        return $this->db->resultSet();
    }

    public function getDoctorAvailableDays($doctorId)
    {
        $this->db->query('SELECT DISTINCT day FROM doctor_time_slots WHERE doctor_id = :doctor_id ORDER BY FIELD(day, "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday")');
        $this->db->bind(':doctor_id', $doctorId);
        $results = $this->db->resultSet();

        $days = [];
        foreach ($results as $result) {
            $days[] = $result->day;
        }

        return $days;
    }

    public function formatAvailableDays($days)
    {
        if (empty($days)) {
            return 'Not available';
        }

        if (count($days) <= 2) {
            return implode(', ', $days);
        }

        // Format days like "Monday, Wednesday, Friday"
        return implode(', ', $days);
    }

}