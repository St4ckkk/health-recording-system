<?php

namespace app\helpers;

class TrackingNumber
{
    private $db;
    private $table;

    public function __construct($db = null, $table = 'appointments')
    {
        $this->db = $db;
        $this->table = $table;
    }

    /**
     * Generate a tracking number for appointments
     * 
     * @param string|null $date The date to use in the tracking number (format: Y-m-d)
     * @param string $prefix The prefix to use (default: 'APT')
     * @param int $randomLength The length of the random part (default: 5)
     * @return string The generated tracking number
     */
    public function generateTrackingNumber($date = null, $prefix = 'APT', $randomLength = 5)
    {
        // If no date is provided, use the current date
        if (empty($date)) {
            $dateFormat = date('Ymd');
        } else {
            // Validate and format the provided date
            try {
                $dateObj = new \DateTime($date);
                $dateFormat = $dateObj->format('Ymd');
            } catch (\Exception $e) {
                // If date is invalid, fall back to current date
                error_log("Invalid date provided for tracking number: $date. Using current date instead.");
                $dateFormat = date('Ymd');
            }
        }

        // Generate a random alphanumeric string
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $randomLength; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Combine the parts to create the tracking number
        $trackingNumber = "{$prefix}-{$dateFormat}-{$randomString}";

        // Check if this tracking number already exists in the database
        // If it does, recursively generate a new one
        if ($this->trackingNumberExists($trackingNumber)) {
            return $this->generateTrackingNumber($date, $prefix, $randomLength);
        }

        return $trackingNumber;
    }

    /**
     * Generate a tracking number for follow-up appointments
     * 
     * @param string|null $date The date to use in the tracking number (format: Y-m-d)
     * @return string The generated tracking number
     */
    public function generateFollowUpTrackingNumber($date = null)
    {
        return $this->generateTrackingNumber($date, 'FU', 6);
    }

    /**
     * Check if a tracking number already exists in the database
     * 
     * @param string $trackingNumber The tracking number to check
     * @return bool True if the tracking number exists, false otherwise
     */
    private function trackingNumberExists($trackingNumber)
    {
        if (!$this->db) {
            // If no database connection is provided, assume it doesn't exist
            return false;
        }

        $this->db->query("SELECT COUNT(*) as count FROM {$this->table} WHERE tracking_number = :tracking_number");
        $this->db->bind(':tracking_number', $trackingNumber);
        $result = $this->db->single();

        return ($result && $result->count > 0);
    }
}