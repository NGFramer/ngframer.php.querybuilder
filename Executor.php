<?php

namespace NGFramer\NGFramerPHPSQLServices;

use Exception;

class Executor
{
    // Variables to store query JSON data related to query.
    private static array $queryJson;
    private ?\NGFramer\NGFramerPHPDbService\Database $database;


    // Constructor for the class Database.
    public static function query(array $queryJson): self
    {
        // Set the queryJson to class ($this) from the constructor.
        self::$queryJson = $queryJson;

        // If the queryJson is not empty, then throw an error.
        if (empty(self::$queryJson)) {
            throw new Exception("Database JSON is empty.");
        }

        // If the queryJson has no key named "status_code", then throw an error.
        if (!array_key_exists("status_code", self::$queryJson)) {
            throw new Exception("Incomplete Database JSON, has no status_code.");
        }

        // If the status_code is not 200, then throw an error.
        if (self::$queryJson["status_code"] != 200) {
            throw new Exception("Database JSON was not formulated.");
        }

        // If the queryJson has no key named "query", then throw an error.
        if (!array_key_exists("query", self::$queryJson['response'])) {
            throw new Exception("Incomplete Database JSON, has no query.");
        }
        // Return the class object for further execution.
        return new self();
    }


    // Function to execute the query.
    public function execute(): int|array|bool
    {
        // Create a new instance of the Database class for executing the query.
        $this->database = new \NGFramer\NGFramerPHPDbService\Database();

        // Get the execution method from the queryJson.
        $executionMethod = self::$queryJson['response']['execution_method'] ?? 'prepared';
        // Check and do the execution based on the method.
        if ($executionMethod == 'prepare') {
            return $this->preparedExecution();
        } else if ($executionMethod == 'direct') {
            return $this->directExecution();
        } else {
            throw new Exception("Invalid execution method.");
        }
    }


    // Function to execute the query using prepared statement.
    private function preparedExecution(): int|array|bool
    {
        // Get all the following details from the queryJson.
        $query = self::$queryJson['response']['query'];
        $bindParameters = self::$queryJson['response']['bind_parameters'] ?? [];

        // Try initiating the transaction and record its status.
        $beginTransactionStatus = $this->database->beginTransaction();
        if (!$beginTransactionStatus) {
            throw new Exception("Unable to initiate the transaction.");
        }

        // Prepare the query and bind the parameters.
        $this->database->prepare($query)->bindParams($bindParameters);

        // Now, based on the action, commit or rollback the transaction.
        return $this->runTransaction();
    }


    // Function to execute the query using direct statement.
    private function directExecution(): int|array|bool
    {
        // Try initiating the transaction and record its status.
        $beginTransactionStatus = $this->database->beginTransaction();
        if (!$beginTransactionStatus) {
            throw new Exception("Unable to initiate the transaction.");
        }

        // Now, based on the action, commit or rollback the transaction.
        return $this->runTransaction();
    }


    // Function to run the transaction based on the action.
    public function runTransaction(): int|array|bool
    {
        // Get the query and action from the queryJson.
        $query = self::$queryJson['response']['query'];
        $action = self::$queryJson['response']['action'];

        // Now, execute the query, and check, if the execution is successful, commit it, else rollback the transaction.
        try {
            $this->database->execute($query);
            $this->database->commit();
        } catch (Exception $e) {
            error_log($e);
            $this->database->rollBack();
            throw new Exception("Error executing the query.");
        }

        // Now, based on the action, commit or rollback the transaction.
        if ($action == 'insertData') {
            // Find the last inserted ID.
            return $this->database->lastInsertId();
        } elseif ($action == 'updateData' or $action == 'deleteData') {
            // Find the number of rows affected.
            return $this->database->rowCount();
        } elseif ($action == 'selectData') {
            // Fetch all the results.
            return $this->database->fetchAll();
        } elseif (in_array($action, ['alterTable', 'alterView', 'createTable', 'createView', 'dropTable', 'dropView', 'renameTable', 'renameView', 'truncateTable'])) {
            // For all the other data definition based actions, return true.
            return true;
        }
        error_log("Error on the following json data " . json_encode(self::$queryJson) . ".");
        throw new Exception("Invalid action. Please check the action in the query.");
    }
}
