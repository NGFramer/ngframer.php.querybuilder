<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common;

use Exception;

Trait TableColumn
{
    private ?string $selectedColumn = null;


    /**
     * This selects the column for modification or creation.
     * @param string $column
     * @return $this
     */
    protected function select(string $column): static
    {
        $this->selectedColumn = $column;
        return $this;
    }


    protected function getSelectedColumn(): string
    {
        return $this->selectedColumn;
    }


    /**
     * This unselects the column attribute after modification or creation.
     * @return $this
     * @throws Exception
     */
    protected function unselect(): static
    {
        if ($this->selectedColumn == null){
            throw new Exception('You must select a column before unselecting it.');
        }
        $this->selectedColumn = null;
        return $this;
    }


    protected function getColumns(): array
    {
        // Variable to store the column name.
        $columns = [];
        // Loop through the array to get the column name.
        foreach ($this->actionLog['columns'] as $column) {
            $columns[] = $column['name'];
        }
        // Return the column list.
        return $columns;
    }


    /**
     * @throws Exception
     */
    protected function getColumnActionLog(string $column): array
    {
        // Check if the column already exists in the list.
        if ($this->checkColumnExistence($column)) {
            $columnIndex = $this->getIndexOfColumn($column);
            return $this->actionLog['columns'][$columnIndex];
        } else {
            throw new Exception("The column $column does not exists in actionLog.");
        }
    }


    /**
     * This will check if the column exists in the columns key of the actionLog.
     * @param string $column
     * @return bool
     */
    protected function checkColumnExistence(string $column): bool
    {
        // Get the list of columns.
        $columnList = $this->getColumns();
        // Check if the column exists in the column list.
        if (in_array($column, $columnList)) {
            return true;
        }
        return false;
    }


    /**
     * This function will get the index of the column in the list.
     * @return int . Returns the index of the column in the actionLog.
     * @throws Exception
     */
    protected function getIndexOfColumn(string $column): int
    {
        // Check column existence.
        if (!$this->checkColumnExistence($column)) {
            throw new Exception('The column does not exists to get it\'s index.');
        }
        // Get the list of columns.
        $columnList = $this->getColumns();
        // Return the index of the column in the list.
        return array_search($column, $columnList);
    }


    protected function getIndexForNewColumn(): int
    {
        // Check if the actionLog's key column has been set.
        if (!isset($this->actionLog['columns'])) {
            return 0;
        }
        // Finding the index for the new column.
        // Count starts from 0, and index too starts from 1.
        // If nothing, the index shall be 0 as is returned by the count.
        return count($this->actionLog['columns']);
    }
}