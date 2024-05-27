<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

abstract class _Builder
{
    // Variables required to store data for the classes.
    protected array $queryLog = [];


    // Function relating to the queryLog building, logging, and getting.
    abstract public function buildQuery(): string;


    public function buildLog(): array
    {
        return $this->getQueryLog();
    }


    protected function getQueryLog(): array
    {
        return $this->queryLog;
    }


    protected function addQueryLog(string $structure, string $structureName, string $action, array ...$structureBasedValues): void
    {
        // Append the array and make edits to the queryLog.
        $this->queryLog[$structure] = $structureName;
        $this->queryLog['action'] = $action;
        foreach ($structureBasedValues as $attributeName => $attributeValue) {
            $this->queryLog[][$attributeName] = $attributeValue;
        }
    }


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


    // For single values, like the table name and the action.
    // Example, primary = true, unique = true, tableName = 'name of table', etc.
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


    // Supportive function, to check if the array is associative or not.
    protected function isAssocArray(array $array): bool
    {
        // Check if any keys are non-numerical or not starting from 0
        foreach ($array as $key => $value) {
            if (!is_int($key) or $key !== key($array)) {
                return true; // It's a key-value pair
            }
            next($array); // Move to the next key
        }
        return false; // It's just a list of values
    }


    // Supportive function, to check if all the elements of an array are arrays.
    protected function areElementsArray(array $elementContainer): bool
    {
        // Loop through the element container elements.
        foreach ($elementContainer as $element) {
            if (!is_array($element)) {
                return false;
            }
        }
        return true;
    }


    // Get the newer column index.
    protected function getNewColumnIndex($columnName): int
    {
        //
        return !empty($this->getIndexOfColumn($columnName)) ? $this->getIndexOfColumn($columnName) : $this->columnsCount();
    }


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