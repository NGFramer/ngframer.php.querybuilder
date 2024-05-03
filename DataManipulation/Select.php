<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;
class Select{
    public static function build(string $tableName, array $fields = []): string
    {
        // Check if the $fields array's element is string.
        foreach ($fields as $field) {
            if (!is_string($field)) {
                throw new \InvalidArgumentException('Field names must be strings.');
            }
        }
        // Check if the $fields array is empty or not.
        if (empty($fields) || (count($fields) == 1 && $fields[0] = '*')) {
            return "SELECT *";
        } else {
            return "SELECT " . implode(', ', $fields) . "FROM " . $tableName;
        }
    }
}