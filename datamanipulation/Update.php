<?php

namespace NGFramer\NGFramerPHPSQLBuilder\datamanipulation;

class Update
{
    public static function build(string $tableName, array $data = [], bool $goDirect = false, int $bindIndexStarter = 0): string
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
}