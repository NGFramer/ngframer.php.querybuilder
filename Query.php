<?php

namespace NGFramer\NGFramerPHPSQLServices;

use Exception;
use NGFramer\NGFramerPHPSQLServices\TransactionControl\StartTransaction;
use NGFramer\NGFramerPHPSQLServices\TransactionControl\StopTransaction;

Class Query
{
    /**
     * Function to start the database transaction.
     * @return void
     */
    public static function start(): void
    {
        StartTransaction::start();
    }


    /**
     * Function to operate on the table.
     * @param string $tableName
     * @return Table
     */
    public static function table(string $tableName): Table
    {
        return new Table($tableName);
    }


    /**
     * Function to operate on the view.
     * @param string $viewName
     * @return View
     */
    public static function view(string $viewName): View
    {
        return new View($viewName);
    }


    /**
     * Function to commit the database transaction.
     * @throws Exception
     */
    public static function commit(): void
    {
        StopTransaction::commit();
    }


    /**
     * Function to roll back the database transaction.
     * @throws Exception
     */
    public static function rollback(Exception $exception): void
    {
        StopTransaction::rollback($exception);
    }
}
