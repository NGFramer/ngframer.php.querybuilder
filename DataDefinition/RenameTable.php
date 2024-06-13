<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive\_DdlTable;

class RenameTable extends _DdlTable
{
    // Construct function from parent class.
    // Location: RenameTable => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $tableName, string $newTableName)
    {
        parent::__construct($tableName);
        $this->addQueryLog('table', $tableName, 'renameTable');
        $this->addToQueryLogDeep('value', $newTableName);
    }


    // Main function for the class rename.
    // Function rename not required, the constructor did everything required.


    // Function to build the query.
    public function buildQuery(): string
    {
        // Get query log and then the table name.
        $queryLog = $this->getQueryLog();
        $oldTableName = $queryLog['table'];
        $newTableName = $queryLog['value'];
        // Start building the query and return it.
        return "ALTER TABLE `{$oldTableName}` RENAME TO `{$newTableName}`;";
    }
}