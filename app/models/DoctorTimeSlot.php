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

    /**
     * Get time slots for a specific doctor on a specific day
     * 
     * @param int $doctorId The doctor ID
     * @param string $day The day of the week (Monday, Tuesday, etc.)
     * @return array The time slots
     */
    public function getTimeSlotsByDoctorAndDay($doctorId, $day)
    {
        // Debug log
        error_log("getTimeSlotsByDoctorAndDay: doctorId=$doctorId, day=$day");
        
        // First, let's check if this doctor has any time slots at all
        $this->db->query('SELECT COUNT(*) as count FROM doctor_time_slots WHERE doctor_id = :doctor_id');
        $this->db->bind(':doctor_id', $doctorId);
        $totalSlots = $this->db->single()->count;
        error_log("Total time slots for doctor $doctorId: $totalSlots");
        
        // Get all time slots for this doctor to check the exact day values
        $this->db->query('SELECT id, day, start_time, end_time FROM doctor_time_slots WHERE doctor_id = :doctor_id');
        $this->db->bind(':doctor_id', $doctorId);
        $allSlots = $this->db->resultSet();
        
        // Log each time slot with exact day value for debugging
        error_log("All time slots for doctor $doctorId:");
        foreach ($allSlots as $slot) {
            // Log the exact day value with character length and ASCII values to detect hidden characters
            $dayValue = $slot->day;
            $dayLength = strlen($dayValue);
            $asciiValues = [];
            for ($i = 0; $i < $dayLength; $i++) {
                $asciiValues[] = ord($dayValue[$i]);
            }
            error_log("Slot ID: {$slot->id}, Day: '{$dayValue}', Length: $dayLength, ASCII: " . implode(',', $asciiValues) . ", Start: {$slot->start_time}, End: {$slot->end_time}");
        }
        
        // Now get the specific day's time slots
        $this->db->query('SELECT * FROM doctor_time_slots WHERE doctor_id = :doctor_id AND day = :day ORDER BY start_time ASC');
        $this->db->bind(':doctor_id', $doctorId);
        $this->db->bind(':day', $day);
        
        $result = $this->db->resultSet();
        
        // Debug log
        error_log("getTimeSlotsByDoctorAndDay: found " . count($result) . " time slots for day '$day'");
        
        // If no results, let's try a case-insensitive search as a fallback
        if (count($result) == 0) {
            error_log("No results with exact match. Trying case-insensitive search for day: $day");
            
            // Try a case-insensitive search (MySQL specific)
            $this->db->query('SELECT * FROM doctor_time_slots WHERE doctor_id = :doctor_id AND LOWER(day) = LOWER(:day) ORDER BY start_time ASC');
            $this->db->bind(':doctor_id', $doctorId);
            $this->db->bind(':day', $day);
            
            $result = $this->db->resultSet();
            error_log("Case-insensitive search found " . count($result) . " time slots");
            
            // If still no results, try with trimmed values to catch whitespace issues
            if (count($result) == 0) {
                error_log("Still no results. Trying with trimmed values for day: $day");
                
                $this->db->query('SELECT * FROM doctor_time_slots WHERE doctor_id = :doctor_id AND TRIM(day) = TRIM(:day) ORDER BY start_time ASC');
                $this->db->bind(':doctor_id', $doctorId);
                $this->db->bind(':day', $day);
                
                $result = $this->db->resultSet();
                error_log("Trimmed search found " . count($result) . " time slots");
            }
        }
        
        return $result;
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

    /**
     * Get available dates for a doctor in a specific month
     * 
     * @param int $doctorId The doctor ID
     * @param int $month The month (1-12)
     * @param int $year The year
     * @return array Array of available days in the month
     */
    public function getAvailableDatesForMonth($doctorId, $month, $year)
    {
        // Get available days for this doctor
        $availableDays = $this->getDoctorAvailableDays($doctorId);
        
        if (empty($availableDays)) {
            return [];
        }
        
        // Convert day names to day numbers (0 = Sunday, 1 = Monday, etc.)
        $dayNumbers = [];
        foreach ($availableDays as $day) {
            switch ($day) {
                case 'Monday': $dayNumbers[] = 1; break;
                case 'Tuesday': $dayNumbers[] = 2; break;
                case 'Wednesday': $dayNumbers[] = 3; break;
                case 'Thursday': $dayNumbers[] = 4; break;
                case 'Friday': $dayNumbers[] = 5; break;
                case 'Saturday': $dayNumbers[] = 6; break;
                case 'Sunday': $dayNumbers[] = 0; break;
            }
        }
        
        // Get all dates in the month that match the available days
        $availableDates = [];
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $today = date('Y-m-d');
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
            $dayOfWeek = date('w', strtotime($date)); // 0 = Sunday, 1 = Monday, etc.
            
            // Check if this day of the week is available and the date is not in the past
            if (in_array($dayOfWeek, $dayNumbers) && $date >= $today) {
                $availableDates[] = $day;
            }
        }
        
        return $availableDates;
    }
}

