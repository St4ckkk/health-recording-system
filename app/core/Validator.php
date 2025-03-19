<?php

namespace app\core;

class Validator
{
    private $errors = [];
    private $data = [];

    /**
     * Create a new validator instance
     * 
     * @param array $data The data to validate
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Set data to validate
     * 
     * @param array $data The data to validate
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get all validation errors
     * 
     * @return array The validation errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Get first error message
     * 
     * @return string|null The first error message or null if no errors
     */
    public function getFirstError()
    {
        return !empty($this->errors) ? reset($this->errors) : null;
    }

    /**
     * Check if validation passed
     * 
     * @return bool True if validation passed, false otherwise
     */
    public function passes()
    {
        return empty($this->errors);
    }

    /**
     * Check if validation failed
     * 
     * @return bool True if validation failed, false otherwise
     */
    public function fails()
    {
        return !$this->passes();
    }

    /**
     * Validate required fields
     * 
     * @param array $fields The fields to validate
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function required($fields, $message = null)
    {
        foreach ((array) $fields as $field) {
            $value = $this->getValue($field);
            if (empty($value) && $value !== '0' && $value !== 0) {
                $this->errors[$field] = $message ?: "The {$field} field is required.";
            }
        }
        return $this;
    }

    /**
     * Validate email format
     * 
     * @param string|array $fields The field(s) to validate
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function email($fields, $message = null)
    {
        foreach ((array) $fields as $field) {
            $value = $this->getValue($field);
            if (!empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->errors[$field] = $message ?: "The {$field} must be a valid email address.";
            }
        }
        return $this;
    }

    /**
     * Validate minimum length
     * 
     * @param string|array $fields The field(s) to validate
     * @param int $length The minimum length
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function minLength($fields, $length, $message = null)
    {
        foreach ((array) $fields as $field) {
            $value = $this->getValue($field);
            if (!empty($value) && strlen($value) < $length) {
                $this->errors[$field] = $message ?: "The {$field} must be at least {$length} characters.";
            }
        }
        return $this;
    }

    /**
     * Validate maximum length
     * 
     * @param string|array $fields The field(s) to validate
     * @param int $length The maximum length
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function maxLength($fields, $length, $message = null)
    {
        foreach ((array) $fields as $field) {
            $value = $this->getValue($field);
            if (!empty($value) && strlen($value) > $length) {
                $this->errors[$field] = $message ?: "The {$field} must not exceed {$length} characters.";
            }
        }
        return $this;
    }

    /**
     * Validate numeric value
     * 
     * @param string|array $fields The field(s) to validate
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function numeric($fields, $message = null)
    {
        foreach ((array) $fields as $field) {
            $value = $this->getValue($field);
            if (!empty($value) && !is_numeric($value)) {
                $this->errors[$field] = $message ?: "The {$field} must be a number.";
            }
        }
        return $this;
    }

    /**
     * Validate array has minimum items
     * 
     * @param string $field The field to validate
     * @param int $min The minimum number of items
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function minItems($field, $min, $message = null)
    {
        $value = $this->getValue($field);
        if (is_array($value) && count($value) < $min) {
            $this->errors[$field] = $message ?: "The {$field} must have at least {$min} items.";
        }
        return $this;
    }

    /**
     * Validate file size
     * 
     * @param string $field The field to validate
     * @param int $maxSize Maximum file size in bytes
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function fileSize($field, $maxSize, $message = null)
    {
        $file = $this->getValue($field);
        if (isset($file['size']) && $file['size'] > $maxSize) {
            $this->errors[$field] = $message ?: "The {$field} must not exceed " . ($maxSize / 1024 / 1024) . "MB.";
        }
        return $this;
    }

    /**
     * Validate file type
     * 
     * @param string $field The field to validate
     * @param array $allowedTypes Allowed MIME types
     * @param string $message Custom error message (optional)
     * @return $this
     */
    public function fileType($field, $allowedTypes, $message = null)
    {
        $file = $this->getValue($field);
        if (isset($file['type']) && !in_array($file['type'], $allowedTypes)) {
            $this->errors[$field] = $message ?: "The {$field} must be one of the following types: " . implode(', ', $allowedTypes);
        }
        return $this;
    }

    /**
     * Get value from data by field name
     * 
     * @param string $field The field name
     * @return mixed The field value
     */
    private function getValue($field)
    {
        return $this->data[$field] ?? null;
    }
}