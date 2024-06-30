<?php

namespace NGFramer\NGFramerPHPSQLServices;

use Exception;
use NGFramer\NGFramerPHPDbServices\Database;

Class _Executor
{
    // Property relating to connection to the database.
    private static ?Database $database = null;

    // Properties to store values for this class.
    private string $action;
    private string $query;
    private array $bindValues;

    // Properties to make this a singleton class.
    private static ?self $instance = null;


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
     * Part of the singleton pattern.
     * Function to create a single instance of this class.
     * @return self
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Part of the singleton pattern.
     * Function to make it allow no instance of this class directly.
     */
    private function __construct()
    {
    }


    /**
     * This function is the main function for the class.
     * Gets the action, query and bindValues and runs the function to execute the query based on the method of execution asked.
     * @throws Exception
     */
    public function execute(string $action, string $query, array $bindValues = [], bool $goDirect = false): int|array|bool
    {
        // Fetch all the data required for the execution.
        $this->action = $action;
        $this->query = $query;
        $this->bindValues = $bindValues;

        // Go direct used only in this function.

        // We will need connection for everything, this is only for executing without starting transaction.
        // Connection will be automatically made is the transaction has started.
        self::connect();

        // Check and implement if we need to execute using prepared statement or not.
        if ($goDirect) {
            return $this->directExecution();
        } else {
            return $this->preparedExecution();
        }
    }


    /**
     * Function to execute the query using prepared statement.
     * @throws Exception
     */
    private function preparedExecution(): int|array|bool
    {
        // Prepare the query and bind the parameters.
        self::$database->prepare($this->query)->bindValues($this->bindValues);

        // Now, execute the transaction and then fetch the output.
        self::$database->execute();
        return $this->fetchOutput();
    }


    /**
     * Function to execute the query using direct statement.
     * @throws Exception
     */
    private function directExecution(): int|array|bool
    {
        // Just execute the transaction and then fetch the output.
        self::$database->execute($this->query);
        return $this->fetchOutput();

    }


    /**
     * This function returns the most important type of output based on the action.
     * @return int|array|bool. Value most significant for further execution.
     */
    private function fetchOutput(): int|array|bool
    {
        // Get the action from the class.
        $action = $this->action;

        // Now, based on the action, commit or rollback the transaction.
        if ($action == 'insertData') {
            // Find the last inserted ID.
            return self::$database->lastInsertId();
        } elseif ($action == 'updateData' or $action == 'deleteData') {
            // Find the number of rows affected.
            return self::$database->rowCount();
        } elseif ($action == 'selectData') {
            // Fetch all the results.
            return self::$database->fetchAll();
        }

        // alterTable, alterView, createTable, createView, dropTable, dropView, renameTable, renameView, truncateTable.
        // For all the other data definition based actions, return true.
        else return true;
    }
}