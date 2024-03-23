<?php

namespace NGFramer\NGFramerPHPSQLBuilder\datamanipulation;

class Delete
{
    public static function build(string $tableName): string
    {
        $query = "DELETE FROM " . $tableName;
        return $query;
    }
}