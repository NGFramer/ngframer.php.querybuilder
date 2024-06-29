<?php

namespace NGFramer\NGFramerPHPSQLServices\TransactionControl;

use NGFramer\NGFramerPHPSQLServices\_Connection;

class StartTransaction
{
    // Use the following connection.
    use _Connection;


    /**
     * Don't allow any instantiation to this class.
     */
    private function __construct()
    {
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

