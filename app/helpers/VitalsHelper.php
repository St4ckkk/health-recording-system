<?php
function calculateBMI($weight, $height_string)
{
    // Weight is already in kg, no need to convert
    $weight_kg = floatval($weight);

    // Check if height is in decimal format (assuming centimeters)
    if (is_numeric($height_string)) {
        // Convert height from cm to meters
        $height_m = floatval($height_string) / 100;
    } else {
        // Convert height from feet'inches" format to meters
        $height_parts = explode("'", str_replace('"', '', $height_string));
        $feet = floatval($height_parts[0]);
        $inches = isset($height_parts[1]) ? floatval($height_parts[1]) : 0;
        $total_inches = ($feet * 12) + $inches;
        $height_m = $total_inches * 0.0254;
    }

    error_log("Weight kg: $weight_kg, Height m: $height_m");

    // Calculate BMI (ensure we don't divide by zero)
    return ($height_m > 0) ? ($weight_kg / ($height_m * $height_m)) : 0;
}