<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Drop
{
    public static function build(string $tableName): string
    {
        // Initialize the query with the table name and return.
        return "DROP TABLE IF EXISTS " . $tableName;
    }
}