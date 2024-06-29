<?php

namespace NGFramer\NGFramerPHPSQLServices\TransactionControl;

use Exception;
use NGFramer\NGFramerPHPSQLServices\_Connection;

class StopTransaction
{
    // Use the following traits.
    use _Connection;


    // Function to commit the transaction.

    /**
     * @throws Exception
     */
    public static function commit(): void
    {
        // Check if the database connection is set.
        if (!empty(self::$database)) {
            // Commit the transaction.
            self::$database->commit();
            self::$database->close();
        }
        else {
            throw new Exception("Error, No connection for commit.");
        }
    }

    /**
     * @throws Exception
     */
    public static function rollback(Exception $exception): void
    {
        // Check if the database connection is set.
        if (!empty(self::$database)) {
            // Rollback the transaction.
            self::$database->rollback();
            self::$database->close();
            // Finally throw the exception.
            throw $exception;
        }
        else {
            throw new Exception("Error, No connection for rollback.");
        }
    }

}