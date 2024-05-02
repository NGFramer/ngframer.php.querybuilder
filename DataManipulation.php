<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

class DataManipulation
{
    public static function select(string $tableName, array $fields = []): string
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


    public static function insert(string $tableName, array $data = [], bool $goDirect = false, int $bindIndexStarter = 0): string
    {
        $query = "INSERT INTO " . $tableName . " ";
        $columns = implode(', ', array_keys($data));
        $query .= "(" . $columns . ") VALUES ";

        // Direct Execution: Add escaped values directly
        if ($goDirect) {
            $values = array_map(function($value) {
                return "'" . addslashes($value) . "'";
            }, array_values($data));
            $query .= "(" . implode(', ', $values) . ")";
        }

        // Prepared Statements: Add placeholders
        else {
            $placeholders = [];
            for ($i = 0; $i < count($data); $i++) {
                $index = $bindIndexStarter + $i;
                $placeholders[] = ':param' . $index;
            }
            $query .= "(" . implode(', ', $placeholders) . ")";
        }

        // Return the query built.
        return $query;
    }


    public static function update(string $tableName, array $data = [], bool $goDirect = false, int $bindIndexStarter = 0): string
    {
        // Initializer part of Query
        $query = "UPDATE " . $tableName . " SET ";
        // The part that will contain information to update.
        $setParts = [];
        foreach ($data as $field => $value) {
            if ($goDirect) {
                $setParts[] = $field . " = '" . addslashes($value) . "'";
            } else {
                $index = $bindIndexStarter + count($setParts);
                $setParts[] = $field . " = :param" . $index;
            }
        }
        // Build the entire query.
        $query .= implode(', ', $setParts);
        // Return the query.
        return $query;
    }


    public static function delete(string $tableName): string
    {
        return "DELETE FROM " . $tableName;
    }
}