<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class Truncate
{
    public static function build(string $tableName): string
    {
        // Initialize the query with a table name and return it.
        return "TRUNCATE TABLE $tableName IF EXISTS";
    }
}