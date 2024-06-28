<?php

namespace NGFramer\NGFramerPHPSQLServices;

use NGFramer\NGFramerPHPDbServices\Database;

trait _Connection
{
    private static ?Database $database = null;

    private static function connect(): void
    {
        if (empty(self::$database)) {
            if (!class_exists(Database::class)) {
                throw new \Exception("Database class not found!");
                error_log("Database class not found!");
            }
            self::$database = Database::getInstance();
        }
    }
}
