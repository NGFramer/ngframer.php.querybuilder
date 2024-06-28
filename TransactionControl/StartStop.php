<?php

namespace NGFramer\NGFramerPHPSQLServices\TransactionControl;

use Exception;
use NGFramer\NGFramerPHPDbServices\Database;
use NGFramer\NGFramerPHPSQLServices\_Connection;

Trait StartStop
{
    // Use the following traits.
    use _Connection;


    // Function to start the transaction.
    public static function start(): void
    {
        // Connect to the database.
        self::connect();
        // Now start the transaction.
        self::$database->beginTransaction();
    }


    public static function stop(Exception $e = null): void
    {
        // Check if the database connection is set.
        if (!empty(self::$database)) {
            // Check for exception and rollback the transaction.
            if (!empty($e)) {
                // Rollback the transaction.
                self::$database->rollback();
            }
            // If no exceptions, commit the transaction.
            else {
                // Commit the transaction.
                self::$database->commit();
            }
            // Close the database connection.
            self::$database->close();
        }
    }
}