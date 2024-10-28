<?php

namespace NGFramer\NGFramerPHPSQLServices\Utilities;

use DateTime;
use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

class ValueSanitizer
{

    /**
     * Private constructor so it can't be instantiated.
     */
    private function __construct()
    {
    }


    public static function sanitizeString(string $value): string
    {
        // Escape special characters in the string to prevent SQL injection.
        $escapedValue = addslashes($value);
        // Convert special characters to HTML entities for display safety (optional).
        return htmlspecialchars($escapedValue);
    }

    public static function sanitizeInteger(int $value): int
    {
        // Ensure the input is an integer.
        return intval($value);
    }

    /**
     * Escapes special LIKE pattern characters using the database's escape character.
     *
     * @param string $value The LIKE pattern string to escape
     * @return string The escaped LIKE pattern string
     */
    public static function escapeLikePattern(string $value): string
    {
        // TODO: Define the database-specific escape character
        $escapeChar = '\\'; // Example: MySQL uses backslash

        // Escape the LIKE pattern special characters
        return str_replace(
            [$escapeChar, '%', '_'],
            [$escapeChar . $escapeChar, $escapeChar . '%', $escapeChar . '_'],
            $value
        );
    }

    /**
     * Validates and sanitizes a date/time string against a specified format.
     *
     * @param string $value The date/time string to sanitize
     * @param string $format The expected date/time format
     * @return string The sanitized date/time string
     * @throws SqlServicesException If the date/time string is invalid
     */
    public static function sanitizeDateTime(string $value, string $format = 'Y-m-d H:i:s'): string
    {
        // Create a DateTime object from the input string and format
        $dateTime = DateTime::createFromFormat($format, $value);

        // Validate the DateTime object
        if (!$dateTime || $dateTime->format($format) !== $value) {
            throw new SqlServicesException("Invalid date/time format. Expected format: $format.", 5055001, 'sqlservices.utility.value.invalidDateTimeFormat');
        }

        // Return the sanitized date/time string in the specified format
        return $dateTime->format($format);
    }

    /**
     * Sanitizes an array of values.
     *
     * @param array $values The array of values to sanitize
     * @param string $dataType The data type of the values ('string', 'integer', 'datetime', etc.)
     * @return array The sanitized array of values
     * @throws SqlServicesException if an unsupported data type is provided
     */
    public static function sanitizeArray(array $values, string $dataType): array
    {
        $sanitizedValues = [];
        foreach ($values as $value) {
            $sanitizedValues[] = match ($dataType) {
                'string' => self::sanitizeString($value),
                'integer' => self::sanitizeInteger($value),
                'datetime' => self::sanitizeDateTime($value),
                // ... add support for other data types as needed
                default => throw new SqlServicesException("Unsupported data type: $dataType.", 5055002, 'sqlservices.unsupported_data_type'),
            };
        }
        return $sanitizedValues;
    }
}