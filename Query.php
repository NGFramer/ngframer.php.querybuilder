<?php

namespace NGFramer\NGFramerPHPSQLServices;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\TableActions;
use NGFramer\NGFramerPHPSQLServices\Actions\ViewActions;
use NGFramer\NGFramerPHPSQLServices\Actions\TransactionControl\StartTransaction;
use NGFramer\NGFramerPHPSQLServices\Actions\TransactionControl\StopTransaction;
use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

final class Query
{
    /**
     * Private constructor, so it can't be instantiated.
     */
    private function __construct()
    {
    }


    /**
     * Function to start the database transaction.
     * @return void
     * @throws SqlServicesException
     */
    public static function start(): void
    {
        StartTransaction::start();
    }


    /**
     * Function to operate on the table.
     * @param string $tableName
     * @return TableActions
     */
    public static function table(string $tableName): TableActions
    {
        return new TableActions($tableName);
    }


    /**
     * Function to operate on the view.
     * @param string $viewName
     * @return ViewActions
     */
    public static function view(string $viewName): ViewActions
    {
        return new ViewActions($viewName);
    }


    /**
     * Function to commit the database transaction.
     * @throws SqlServicesException
     */
    public static function commit(): void
    {
        StopTransaction::commit();
    }


    /**
     * Function to roll back the database transaction.
     * @throws SqlServicesException
     */
    public static function rollback(Exception $exception): void
    {
        StopTransaction::rollback($exception);
    }
}
