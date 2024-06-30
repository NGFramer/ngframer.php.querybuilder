<?php

namespace NGFramer\NGFramerPHPSQLServices\TransactionControl;

use NGFramer\NGFramerPHPDbServices\Database;

class StartTransaction
{
    // Property relating to connection to the database.
    private static ?Database $database = null;


    /**
     * Function to not allow any instance of this class.
     */
    private function __construct()
    {
    }


    /**
     * Function to create a single database instance.
     * @return void
     */
    private static function connect(): void
    {
        if (empty(self::$database)) {
            self::$database = Database::getInstance();
        }
        // Getting instance automatically sets the database connection.
    }


    /**
     * Function to start the transaction.
     */
    public static function start(): void
    {
        // Connect to the database.
        self::connect();
        // Now start the transaction.
        self::$database->beginTransaction();
    }
}

