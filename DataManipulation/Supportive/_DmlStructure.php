<?php

namespace NGFramer\NGFramerPHPSQLServices\DataManipulation\Supportive;

use Exception;
use NGFramer\NGFramerPHPSQLServices\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLServices\_Base;
use NGFramer\NGFramerPHPSQLServices\_Executor;

abstract class _DmlStructure extends _Base
{
    // Variable defined here.
    private bool $goDirect = false;
    private array $bindValues = [];
    private array $structure;
    private array $queryBuilt = [];


    /**
     * Constructor function for the class.
     * @throws SqlBuilderException
     */
    protected function __construct(string $structureType, string $structureValue)
    {
        if (empty($structureType)) {
            throw new SqlBuilderException('Structure type cannot be empty. Please provide a structure type.', 0, null, 500, ['error_type' => 'dml_structureType_notDefined']);
        }
        if (empty($structureValue)) {
            throw new SqlBuilderException("$structureType name cannot be empty. Please provide a structure value.", 0, null, 500, ['dml_structureValue_notDefined',]);
        }
        $this->setStructure($structureType, $structureValue);
    }


    protected function setStructure(string $structureType, string $structureValue): void
    {
        $this->structure['type'] = $structureType;
        $this->structure['value'] = $structureValue;
    }


    protected function getStructureValue(): string
    {
        return $this->structure['value'];
    }


    /**
     * Functions used for defining the query execution method.
     * @return mixed
     */
    protected function goDirect(): mixed
    {
        // Use this function to set the method of executing the query to direct (not using prepare).
        $this->goDirect = true;
        // Returning nothing, only for compatibility, mixed to reuse in the further classes.
        return null;
    }


    /**
     * Function to check if execution method is direct.
     * @return bool
     */
    protected function isGoDirect(): bool
    {
        return $this->goDirect;
    }


    /**
     * Function to update/add to the bind values.
     * @throws SqlBuilderException
     */
    protected function updateBindValues(string $column, string $value): void
    {
        if (array_key_exists($column, $this->bindValues)) {
            throw new SqlBuilderException("Something unexpected happened. Repeated bindParameters column.", 0, null, 500, ['error_type' => 'dml_repeatedBindParametersKey']);
        } else {
            $this->bindValues[$column] = $value;
        }
    }


    /**
     * Provides number to use further for the another binding, array starts from 0th position.
     * @return int
     */
    protected function getBindIndexStarter(): int
    {
        // Bind parameter will start from 1.
        return !$this->goDirect ? (count($this->bindValues) + 1) : 0;
    }


    protected function sanitizeValue(string $value): string
    {
        // Escape special characters in the string
        $escapedValue = addslashes($value);
        // Convert special characters to HTML entities
        return htmlspecialchars($escapedValue);
    }


    /**
     * Builds the bind parameters array.
     * Uses the function buildQuery when this function is executed independently and alone.
     * @return array
     */
    public function buildBindValues(): array
    {
        // Only if the bindValues array is empty, then build the query.
        // Only for the purpose of only building the bindValues.
        // The parameters to be bound is created only when the query is built.
        if (empty($this->bindValues)) {
            $queryBuilt = $this->buildQuery();
        }

        // Then, Initialize the bind parameters array.
        $bindValues = [];
        // Loop through the bind parameters and build the bind parameters array.
        foreach ($this->bindValues as $columnName => $columnValue) {
            $bindValues[] = ['column' => $columnName, 'value' => $columnValue];
        }
        // Return the bind parameters array.
        return $bindValues;
    }


    /**
     * This uses multiple build functions, and is the function that we use to build the query.
     * This is the only function other than buildLog() that will be used during the production purposes.
     * @return array. The query result in the form of API response.
     */
    public function build(): array
    {
        // Run this only if the query has not been built.
        if (empty($this->queryBuilt)) {
            // Get the build Log and build the action.
            $buildLog = $this->getQueryLog();
            $action = $buildLog['action'];
            // Return the response.
            $resultArray = [
                'success' => true,
                'status_code' => 200,
                'response' => [
                    'action' => $action,
                    'execution_method' => $this->isGoDirect() ? 'direct' : 'prepare',
                    'query' => $this->buildQuery()
                ],
            ];
            // Check if the execution method is direct, if so, add bind_parameters.
            if (!$this->isGoDirect()) {
                $resultArray['response']['bind_values'] = $this->buildBindValues();
            }
            // Save the result array.
            $this->queryBuilt = $resultArray;
        }
        // Return the result array.
        return $this->queryBuilt;
    }


    /**
     * Uses the _Executor class for the execution.
     * Executes the query that has been made using the selected method of execution.
     * @return array|bool|int. Returns the most appropriate and suitable response type of data.
     * @throws Exception
     */
    public function execute(): array|bool|int
    {
        // Firstly, run the build function.
        $this->build();
        // Now fetch the values.
        $action = $this->queryBuilt['response']['action'];
        $query = $this->queryBuilt['response']['query'];
        $bindValues = $this->queryBuilt['response']['bind_values'];
        $goDirect = $this->isGoDirect();
        // Now pass all the values to the _Executor.
        return _Executor::getInstance()->execute($action, $query, $bindValues, $goDirect);
    }
}
