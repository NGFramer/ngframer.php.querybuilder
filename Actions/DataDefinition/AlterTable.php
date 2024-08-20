<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common\TableColumn;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common\AddColumnAttribute;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common\DropColumnAttribute;

final class AlterTable extends StructureTable
{
    /**
     * Use the following traits.
     */
    use TableColumn;
    use AddColumnAttribute;
    use DropColumnAttribute;


    /**
     * This sets the tableName and the action to the actionLog.
     * @param string $table
     * @throws SqlServicesException
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('alterTable');
        return $this;
    }


    /**
     * This will add the column to the actionLog[columns].
     * @param string $column
     * @return void
     * @throws SqlServicesException
     */
    public function addColumn(string $column): void
    {
        // Check if the column already exists in the list.
        if (in_array($column, $this->getColumns())) {
            throw new SqlServicesException("Column $column already exists", 5006009);
        }
        // Get the column index for new column.
        $columnIndex = $this->getIndexForNewColumn();

        // If the column does not exist in the list, add it to the list.
        $this->addToActionLog('columns', $columnIndex, ['action' => 'addColumn', 'column' => $column]);
        $this->select($column);
    }


    /**
     * This will initialize the column in the actionLog[columns], and select for further operations.
     * @param string $column
     * @return void
     * @throws SqlServicesException
     */
    public function updateColumn(string $column): void
    {
        // Check if the column already exists in the list.
        if ($this->checkColumnExistence($column)) {
            $columnIndex = $this->getIndexOfColumn($column);
        } else {
            $columnIndex = $this->getIndexForNewColumn();
        }

        // If the column does not exist in the list, add it to the list.
        $this->addToActionLog('columns', $columnIndex, ['action' => 'updateColumn', 'column' => $column]);
        $this->select($column);
    }


    /**
     * This will set the actionLog to drop the column mentioned.
     * @param string $column
     * @return void
     * @throws SqlServicesException
     */
    public function dropColumn(string $column): void
    {
        // Check if the column already exists in the list.
        if ($this->checkColumnExistence($column)) {
            throw new SqlServicesException('You can\'t drop a column that is being updated in this transaction.', 5006003);
        } else {
            $columnIndex = $this->getIndexForNewColumn();

            // If the column does not exist in the list, add it to the list.
            $this->addToActionLog('columns', $columnIndex, ['action' => 'dropColumn']);
            $this->addToActionLog('columns', $columnIndex, ['column' => $column]);
            $this->unselect();
        }
    }


    /**
     * Base function to add all types of column attributes.
     * @param string $attributeName
     * @param mixed $attributeValue
     * @return void
     * @throws SqlServicesException
     */
    private function addColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        // Check if a column has been selected or not.
        $column = $this->getSelectedColumn();
        if ($column == null) {
            throw new SqlServicesException('Please select a column before adding an attribute to the column/field.', 5003004);
        }

        // Check if the column already exists in the list.
        if ($this->checkColumnExistence($column)) {
            $columnIndex = $this->getIndexOfColumn($column);
        } else {
            $columnIndex = $this->getIndexForNewColumn();
        }

        // Check if the column is being dropped.
        $columnActionLog = $this->getColumnActionLog($column);
        if ($columnActionLog['action'] == 'dropColumn') {
            throw new SqlServicesException('You can\'t add an attribute to a column that is being dropped.', 5006004);
        }

        // Check if the attribute has been updated in this transaction.
        if (isset($columnActionLog[$attributeName])) {
            throw new SqlServicesException("The column is updating the $attributeName value already.", 5006005);
        }

        // If the column does not exist in the list, add it to the list.
        $this->addToActionLog('columns', $columnIndex, [$attributeName => $attributeValue]);
        $this->select($column);
    }


    /**
     * Base function to change or drop the column attributes.
     * @param string $attributeName
     * @param mixed $attributeValue
     * @return void
     * @throws SqlServicesException
     */
    private function updateColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        // Check if a column has been selected or not.
        $column = $this->getSelectedColumn();
        if ($column == null) {
            throw new SqlServicesException('You must select a column before changing attribute on it', 5006006);
        }

        // Check if the column already exists in the list.
        if ($this->checkColumnExistence($column)) {
            $columnIndex = $this->getIndexOfColumn($column);
        } else {
            $columnIndex = $this->getIndexForNewColumn();
        }

        // Check if the column is being dropped or added. Change is not available for addColumn and dropColumn.
        $columnActionLog = $this->getColumnActionLog($column);
        if ($columnActionLog['action'] == 'dropColumn' or $columnActionLog['action'] == 'addColumn') {
            throw new SqlServicesException('You can\'t update an attribute to a column that is being dropped or added.', 5006007);
        }

        // Check if the attribute is already being updated in this transaction.
        if (isset($columnActionLog[$attributeName])) {
            throw new SqlServicesException("The column is updating the $attributeName value already.", 5006008);
        }

        // If the column does not exist in the list, add it to the list.
        $this->addToActionLog('columns', $columnIndex, [$attributeName => $attributeValue]);
        $this->select($column);
    }
}