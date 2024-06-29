<?php

namespace NGFramer\NGFramerPHPSQLServices;

use NGFramer\NGFramerPHPDbServices\Database;

trait _Connection
{
    private static ?Database $database = null;

    private static function connect(): void
    {
        if (empty(self::$database)) {
            self::$database = Database::getInstance();
        }
        // Getting instance automatically sets the database connection.
    }
}
