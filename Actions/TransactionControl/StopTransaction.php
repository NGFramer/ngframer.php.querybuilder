<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\TransactionControl;

use Exception;
use NGFramer\NGFramerPHPExceptions\Exceptions\BaseException;
use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPDbServices\Database;

class StopTransaction
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
            try {
                self::$database = Database::getInstance();
            } catch (BaseException $exception) {
                throw new SqlServicesException($exception->getMessage(), $exception->getCode(), $exception->getLabel(), $exception);
            }
        }
        // Getting instance automatically sets the database connection.
    }


    /**
     * Function to commit the transaction.
     * @throws SqlServicesException
     */
    public static function commit(): void
    {
        // If the database connection is not defined.
        if (empty(self::$database)) {
            self::connect();
        }

        // Commit the transaction.
        try {
            self::$database->commit();
        } catch (BaseException $exception) {
            // Finally, throw the exception.
            throw new SqlServicesException($exception->getMessage(), $exception->getCode(), $exception->getLabel(), $exception);
        }
    }

    /**
     * Function to roll back the transaction.
     * @throws SqlServicesException
     */
    public static function rollback(Exception $exception): void
    {
        // Check if the database connection is set.
        if (empty(self::$database)) {
            self::connect();
        }
        // Roll back the transaction.
        try {
            self::$database->rollback();
        } catch (BaseException $exception) {
            // Finally, throw the exception.
            throw new SqlServicesException($exception->getMessage(), $exception->getCode(), $exception->getLabel(), $exception);
        }
    }

}