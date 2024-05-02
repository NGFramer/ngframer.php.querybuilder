<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

// Non-functional class. Only set's and gets the table name.
Class Table {
    private static ?string $tableName = null;

    public static function getTableName(): string
    {
        return self::$tableName;
    }

    public static function setTableName($tableName): void
    {
        self::$tableName = $tableName;
    }
}
