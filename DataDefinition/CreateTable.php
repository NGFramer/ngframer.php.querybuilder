<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlDefault;
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
    public function addColumn($columnName): self
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
    public function buildQuery(): string
    {
        $tableName = $this->getQueryLog()['table'];
        // Initialize the final creation query.
        $query = "CREATE TABLE IF NOT EXISTS `$tableName` (";
        // Turn for processing the columns query.
        $columns = $this->getQueryLog()['columns'] ?? [];
        // Check if the $column is set or not and empty or not.
        if (empty($columns)) {
            throw new SqlBuilderException('No columns found to create table', 0, null, 500, ['error_type'=>'ddlCreateTable_columns_notDefined']);
        }
        // Loop through the columns and build the column query.
        foreach ($columns as $column) {
            $query .= $this->buildColSql($column) . ', ';
        }
        // Remove the last comma from the query.
        $query = rtrim($query, ', ');
        // Close the query with the closing bracket.
        $query .= ')';
        // Return the finalized query.
        return $query;
    }


    // Helper function for build to build column attribute.
    public function buildColSql(array $columnDefinition): string
    {
        if (!isset($columnDefinition['column'])) {
            throw new SqlBuilderException('Column name is required', 0, null, 500, ['error_type'=>'ddl_columnName_notDefined']);
        }
        if (!isset($columnDefinition['type'])) {
            throw new SqlBuilderException('Column type for ' . $columnDefinition['column'] . ' is required', 0, null,500, ['error_type'=>'ddl_columnType_notDefined']);
        }
        if (!isset($columnDefinition['length'])) {
            $columnDefinition['length'] = _DdlDefault::getLength($columnDefinition['type']);
        }
        // Main column definition query.
        $columnSql = '`' . $columnDefinition['column'] . '`' . ' ' . $columnDefinition['type'] . '(' . $columnDefinition['length'] . ')';
        // Check for what attribute comes when at order.
        if (isset($columnDefinition['null']) and $columnDefinition['null'] === true) {
            $columnSql .= 'NULL';
        }
        if (isset($columnDefinition['null']) and $columnDefinition['null'] === false) {
            $columnSql .= ' NOT NULL';
        }
        if (isset($columnDefinition['unique']) and $columnDefinition['unique']) {
            $columnSql .= ' UNIQUE';
        }
        if (isset($columnDefinition['primary']) and $columnDefinition['primary']) {
            $columnSql .= ' PRIMARY KEY';
        }
        if (isset($columnDefinition['autoIncrement']) and $columnDefinition['autoIncrement']) {
            $columnSql .= ' AUTO_INCREMENT';
        }
        if (isset($columnDefinition['default'])) {
            $columnSql .= ' DEFAULT ' . $columnDefinition['default'];
        }
        if (isset($columnDefinition['foreign'])) {
            $columnSql .= ' FOREIGN KEY (' . $columnDefinition['column'] . ') REFERENCES ' . $columnDefinition['foreign']['table'] . '(' . $columnDefinition['foreign']['column'] . ')';
        }
        // Return the finalized column query.
        return $columnSql;
    }
}