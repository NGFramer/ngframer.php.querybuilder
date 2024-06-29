<?php

namespace NGFramer\NGFramerPHPSQLServices;

use Exception;

trait _Executor
{
    // Use the connection trait.
    use _Connection;


    /**
     * @throws Exception
     */
    private function execute(): void
    {
        // We will need connection for everything, this is only for executing without starting transaction.
        // Connection will be automatically made is the transaction has started.
        self::connect();

        // Check and implement if we need to execute using prepared statement or not.
        if ($this->isGoDirect()) {
            $this->directExecution();
        } else {
            $this->preparedExecution();
        }
    }



    // Function to execute the query using prepared statement.

    /**
     * @throws Exception
     */
    private function preparedExecution(): int|array|bool
    {
        // Get all the following details queryBuilder and queryBindValueBuilder.
        $query = $this->query = $this->buildQuery();
        $bindValues = $this->bindValues = $this->buildBindValues();

        // Try initiating the transaction and record its status.
        $beginTransactionStatus = self::$database->beginTransaction();
        if (!$beginTransactionStatus) {
            throw new Exception("Unable to initiate the transaction.");
        }

        // Prepare the query and bind the parameters.
        self::$database->prepare($query)->bindValues($bindValues);

        // Now, based on the action, commit or rollback the transaction.
        return $this->runTransaction();
    }


    // Function to execute the query using direct statement.

    /**
     * @throws Exception
     */
    private function directExecution(): int|array|bool
    {
        // Get all the following details queryBuilder.
        $query = $this->query = $this->buildQuery();

        // Try initiating the transaction and record its status.
        $beginTransactionStatus = self::$database->beginTransaction();
        if (!$beginTransactionStatus) {
            throw new Exception("Unable to initiate the transaction.");
        }

        // Now, based on the action, commit or rollback the transaction.
        return $this->runTransaction();
    }


    // Function to run the transaction based on the action.

    /**
     * @throws Exception
     */
    private function runTransaction(): int|array|bool
    {
        // Get the query.
        $query = $this->query;

        // Execute the query using prepared or direct execution method based on what has been asked.
        // For the prepared execution method, use the already prepared statement, that has already been bind, just execute it.
        if (!$this->isGoDirect()) {
            self::$database->execute();
        } else {
            self::$database->execute($query);
        }

        // Now fetch the outputs.
        return $this->fetchOutput();
    }


    private function fetchOutput(): array|bool|int|string
    {
        // Get the action.
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
