<?php

namespace NGFramer\NGFramerPHPSQLServices\TransactionControl;

use Exception;
use NGFramer\NGFramerPHPDbServices\Database;
use NGFramer\NGFramerPHPSQLServices\_Connection;

class StopTransaction
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
     * Function to commit the transaction.
     * @throws Exception
     */
    public static function commit(): void
    {
        // If the database connection is not defined.
        if (empty(self::$database)) {
            self::connect();
        }

        // Commit the transaction.
        self::$database->commit();

    }

    /**
     * Function to roll back the transaction.
     * @throws Exception
     */
    public static function rollback(Exception $exception): void
    {
        // Check if the database connection is set.
        if (empty(self::$database)) {
            self::connect();
        }
        // Rollback the transaction.
        self::$database->rollback();
        // Finally throw the exception.
        throw $exception;
    }

}