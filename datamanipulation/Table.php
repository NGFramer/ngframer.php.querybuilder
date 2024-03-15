<?php

namespace NGFramer\NGFramerPHPSQLBuilder\datamanipulation;

// Non functional class. Only set's and get's the table name.
Class Table {
    private static $tableName = null;

    public function getTableName(): string
    {
        return self::$tableName;
    }

    public static function setTableName($tableName): void
    {
        self::$tableName = $tableName;
    }
}
