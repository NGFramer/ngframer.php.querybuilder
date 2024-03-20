<?php

namespace NGFramer\NGFramerPHPSQLBuilder\datamanipulation;

class Insert
{
    public static function build(string $tableName, array $data = [], bool $goDirect = false, int $bindIndexStarter = 0): string
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
}
