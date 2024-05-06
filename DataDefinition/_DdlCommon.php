<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

abstract class _DdlCommon
{
    // Variables to store table and query data.
    protected string $tableName;
    protected string $selectedColumn;
    protected array $queryLog;
    protected int $selectedAction;




    // Everything about the action.
    // The function look into the queryLog and then make a new entry.
    // If I were to do something, it will explain what needs to be done to the table.
    protected function addAction(string $action): void
    {
        $this->queryLog[]['action'] = $action;
        $this->selectedAction = count($this->queryLog) - 1;
    }




    // Everything about the table.
    protected function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    protected function getTableName(): string
    {
        if (empty($this->tableName)) {
            throw new \Exception("No table has been selected. Please select a table before proceeding.");
        }
        return $this->tableName;
    }




    // Everything about the query log.
    // Not to be accessed from anywhere out of this class and extending class.
    protected function logAction(string $action): void
    {
        $this->queryLog[$this->selectedAction]['action'] = $action;
    }
    protected function logTable(string $tableName): void
    {
        $this->queryLog[$this->selectedAction]['table'] = $tableName;
    }

    protected function logColumn(string $tableName, string $columnName): void
    {
        $this->queryLog[$this->selectedAction][$tableName][] = $columnName;
    }

    protected function logColumnAttribute(string $attributeName, string|bool|int|null $attributeValue): void
    {
        $this->queryLog[$this->selectedAction][self::getTableName()][self::getSelectedColumn()][$attributeName] = $attributeValue;
    }




    // The final function to build the result and return the query.
    abstract public function build(): string;
    public function buildLog(): array
    {
        return $this->queryLog;
    }
}