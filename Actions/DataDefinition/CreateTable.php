<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common\AddColumnAttribute;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\Common\TableColumn;

final class CreateTable extends StructureTable
{
    /**
     * Use the following traits.
     */
    use TableColumn;
    use AddColumnAttribute;


    /**
     * This will set tableName and action to actionLog.
     * @param string $table
     * @throws SqlServicesException
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('createTable');
        return $this;
    }


    /**
     * This will add the column to the actionLog[columns].
     * @param string $columnName
     * @return void
     * @throws SqlServicesException
     */
    public function addColumn(string $columnName): void
    {
        // Check if the column already exists in the list.
        if (in_array($columnName, $this->getColumns())) {
            throw new SqlServicesException("Column $columnName already exists", 5006010, 'sqlservices.columnAlreadyExists');
        }
        // If the column does not exist in the list, add it to the list.
        $this->addToActionLog('columns', ['column' => $columnName]);
        $this->select($columnName);
    }


    /**
     * This will add a specified attribute to the selected column.
     * To be used as a foundational function.
     * @param string $attributeName
     * @param mixed $attributeValue
     * @return void
     * @throws SqlServicesException
     */
    private function addColumnAttribute(string $attributeName, mixed $attributeValue): void
    {
        if ($this->getSelectedColumn() == null) {
            throw new SqlServicesException("Please select a column before adding an attribute to the column/field.", 5003004, 'sqlservices.addColumnAttributeError');
        }
        // Get the index of the selected column.
        $columnIndex = $this->getIndexOfColumn($this->getSelectedColumn());
        // Add the attribute to the column.
        $this->addToActionLog('columns', $columnIndex, $attributeName, $attributeValue);
    }
}