<?php

namespace NGFramer\NGFramerPHPSQLBuilder\datamanipulation;

Class Select
{
    public static function build(string $tableName, string ...$fields = null)
    {
        if (empty($fields) || (count($fields) == 1 && $fields[0] = '*') {
            return "SELECT *";
        } else {
            return "SELECT " . implode(', ', $fields) . "FROM " . $tableName;
        }
    }
}
