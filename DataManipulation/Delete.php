<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

class Delete
{
    public static function build(string $tableName): string
    {
        return "DELETE FROM " . $tableName;
    }
}