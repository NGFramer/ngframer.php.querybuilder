<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlTableColumn;

class CreateTable extends _DdlTableColumn
{
    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
        // Initialize the query log, add the table name and the action to alterTable.
        $this->addQueryLog('table', $tableName, 'createTable');
    }




    // Function related to the addition of columns.
    // Logic behind the addition of column:
    // 1. Find the index of the column.
    // 2. Add the column to the query log = [ 'columns' => [ 'column' => $columnName ] ]
    // 3. The third step is to select the query for the addition of more attributes to the column.
    public function addColumn($columnName):self
    {
        // Make modification to the query log, we have added the table name and table's action previously.
        // We find the index for the column, and add the column, and it's name there.
        // Get the columns count.
        // Logic behind this is to get count number of columns, then do -1 as array index starts from 0, and +1 for new Index.
        $newColumnIndex = $this->columnsCount();
        // Add the column to the query log.
        $this->addToQueryLogDeep('columns', $newColumnIndex, 'column', $columnName);
        $this->selectColumn($columnName);
        return $this;
    }




    // Builder function for the class.
    public function build(): string
    {
        return "CREATE TABLE " . $this->getTableName();
        // TODO: Implement build() method.
    }

}