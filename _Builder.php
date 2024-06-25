<?php

namespace NGFramer\NGFramerPHPSQLServices;

use Exception;

trait _Builder
{
    // Variables required to store data for the classes.
    protected array $queryLog = [];
    protected string $action;


    /**
     * Function relating to the queryLog building, logging, and getting.
     * Different for individual classes and traits.
     */
    abstract public function buildQuery(): string;


    /**
     * The function is same with the buildLog function.
     * Just the different that, getQueryLog is used when we're processing the queryLog and not returning for final output.
     */
    protected function getQueryLog(): array
    {
        return $this->queryLog;
    }


    /**
     * @param string|null $action
     * When the parent::setAction is called and action is passed as null, the exception will be thrown.
     * @throws Exception
     */
    protected function setAction(string $action = null): void
    {
        // Function can still be overwritten, and no error will be thrown.
        if ($action == null) {
            throw new Exception("Action for any operations cannot be null.");
        }
        $this->action = $action;

    }


    /**
     * Returns the current action being performed in the column
     * @return string
     * @throws Exception
     */
    protected function getAction(): string
    {
        if (empty($this->action)) {
            throw new Exception("Action for any operations cannot be null.");
        }
        return $this->action;
    }


    /**
     * Utility function.
     * This adds the details to the queryLog (this->queryLog) for the use cases in the time coming.
     * @param string $structure
     * @param string $structureName
     * @param string $action
     * @param array ...$structureBasedValues
     * @return void
     */
    protected function addQueryLog(string $structure, string $structureName, string $action, array ...$structureBasedValues): void
    {
        // Append the array and make edits to the queryLog.
        $this->queryLog[$structure] = $structureName;
        $this->queryLog['action'] = $action;
        foreach ($structureBasedValues as $attributeName => $attributeValue) {
            $this->queryLog[][$attributeName] = $attributeValue;
        }
    }


    /**
     * Utility function.
     * This function is similar to the addToQueryLog which adds details to the just inner layer of the queryLog but it adds the result to the array, example array[] = value.
     * This does not do string action like array['name'] = string but rather array['name'][] = string.
     * @param mixed ...$arguments
     * @return void
     */
    protected function addToQueryLogDeepArray(mixed ...$arguments): void
    {
        // Get the value to be added.
        $value = array_pop($arguments);

        // Traverse the array to reach the target nested level.
        $target = &$this->queryLog;
        foreach ($arguments as $subKey) {
            if (!isset($target[$subKey])) {
                $target[$subKey] = [];
            }
            $target = &$target[$subKey];
        }

        // Add the value at the deepest level
        $target[] = $value;
    }


    /**
     * Utility function.
     * For single values, like the table name and the action.
     * Example, primary = true, unique = true, tableName = 'name of table', etc.
     * @param mixed ...$arguments
     * @return void
     */
    protected function addToQueryLogDeep(mixed ...$arguments): void
    {
        // Get the value to be added.
        $value = array_pop($arguments);

        // Traverse the array to reach the target nested level.
        $target = &$this->queryLog;
        foreach ($arguments as $subKey) {
            if (!isset($target[$subKey])) {
                $target[$subKey] = [];
            }
            $target = &$target[$subKey];
        }

        // Add the value at the deepest level
        $target = $value;
    }


    /**
     * Gets the position of the array for the columnName supplied in the function $columnName .
     * @return int
     * @param $columnName.
     */
    protected function getNewColumnIndex($columnName): int
    {
        return !empty($this->getIndexOfColumn($columnName)) ? $this->getIndexOfColumn($columnName) : $this->columnsCount();
    }


    /**
     * TODO: Description needed for the builder.
     *
     * @param string $columnName
     * @return int|null
     *
     */
    // Supportive function for column operations.
    protected function getIndexOfColumn(string $columnName): int|null
    {
        $columnElementCounter = 0;
        if (!isset($this->queryLog['columns'])) {
            return null;
        }
        foreach ($this->queryLog['columns'] as $columnElements) {
            if (!isset($columnElements['column'])) {
                return null;
            }
            if ($columnElements['column'] == $columnName) {
                return $columnElementCounter;
            }
            $columnElementCounter++;
        }
        return null;
    }


    /**
     * Returns the action for the column. The column action is a must for other than createTable action of the table.
     * @param string $columnName
     * @return string|null
     */
    protected function getActionOfColumn(string $columnName): string|null
    {
        if (!isset($this->queryLog['columns'])) {
            return null;
        }
        foreach ($this->queryLog['columns'] as $columnElements) {
            if (!isset($columnElements['column'])) {
                return null;
            }
            if ($columnElements['column'] == $columnName) {
                return $columnElements['action'] ?? null;
            }
        }
        return null;
    }


    protected function columnsCount(): int
    {
        return $this->getElementsCount($this->queryLog, 'columns');
    }


    protected function getElementsCount(array $source, string $key): int
    {
        if (isset($source[$key])) {
            return count($source[$key]);
        } else {
            return 0;
        }
    }
}