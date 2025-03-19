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

    public function getTimeSlotById($id)
    {
        return $this->getById($id);
    }

    public function getTimeSlotsByDoctorId($doctorId)
    {
        return $this->getByField('doctor_id', $doctorId);
    }

    public function getTimeSlotsByDay($day)
    {
        return $this->getByField('day', $day);
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
    
    /**
     * Insert a new time slot
     * 
     * @param array $data The time slot data
     * @return bool|int The ID of the inserted time slot or false on failure
     */
    public function insert($data)
    {
        $this->db->query('INSERT INTO doctor_time_slots (
            doctor_id,
            day,
            start_time,
            end_time,
            created_at
        ) VALUES (
            :doctor_id,
            :day,
            :start_time,
            :end_time,
            :created_at
        )');

        // Bind values
        $this->db->bind(':doctor_id', $data['doctor_id']);
        $this->db->bind(':day', $data['day']);
        $this->db->bind(':start_time', $data['start_time']);
        $this->db->bind(':end_time', $data['end_time']);
        $this->db->bind(':created_at', $data['created_at'] ?? date('Y-m-d H:i:s'));

        // Execute
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
    
    /**
     * Delete time slots by a specific field
     * 
     * @param string $field The field name
     * @param mixed $value The field value
     * @return bool True on success, false on failure
     */
    public function deleteByField($field, $value)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE {$field} = :{$field}");
        $this->db->bind(":{$field}", $value);
        return $this->db->execute();
    }
    
    public function getDoctorAvailableDaysFormatted($doctorId)
    {
        $days = $this->getDoctorAvailableDays($doctorId);
        return $this->formatAvailableDays($days);
    }

    public function getDoctorsWithAvailability($status = null)
    {
        $sql = "
            SELECT d.*, 
                   COUNT(DISTINCT ts.day) as available_days,
                   GROUP_CONCAT(DISTINCT ts.day ORDER BY 
                     CASE ts.day
                       WHEN 'Monday' THEN 1
                       WHEN 'Tuesday' THEN 2
                       WHEN 'Wednesday' THEN 3
                       WHEN 'Thursday' THEN 4
                       WHEN 'Friday' THEN 5
                       WHEN 'Saturday' THEN 6
                       WHEN 'Sunday' THEN 7
                     END SEPARATOR ', ') as days
            FROM doctors d
            LEFT JOIN doctor_time_slots ts ON d.id = ts.doctor_id
        ";

        if ($status !== null) {
            $sql .= " WHERE d.status = :status";
        }

        $sql .= " GROUP BY d.id ORDER BY d.last_name, d.first_name";

        $this->db->query($sql);

        if ($status !== null) {
            $this->db->bind(':status', $status);
        }

        return $this->db->resultSet();
    }
}