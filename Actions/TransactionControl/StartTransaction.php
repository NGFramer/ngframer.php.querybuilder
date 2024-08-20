<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\TransactionControl;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPDbServices\Database;

class StartTransaction
{
    /**
     * @var Database|null
     * Property relating to connection to the database.
     */
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
     * @throws SqlServicesException
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
     * @throws SqlServicesException
     */
    public static function start(): void
    {
        // Connect to the database.
        self::connect();
        // Only start the transaction if there is no active transaction.
        if (!self::$database->hasActiveTransactions()) {
            // Now start the transaction.
            self::$database->beginTransaction();
        }
        // Else do nothing.
    }
}