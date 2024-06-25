<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive\_DdlTable;

class DropTable extends _DdlTable
{
    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
        $this->addQueryLog('table',$tableName, 'dropTable');
        // Set the action.
        $this->setAction();
    }


    // Set the action for the table.
    protected function setAction($action = null): void
    {
        parent::setAction("dropTable");
    }


    // Main function for the class drop.
    // Function drop not required, the constructor did everything required.


    // Function to build the query.
    public function buildQuery(): string
    {
        return "DROP TABLE " . $this->getTable();
    }


    public function buildLog(): array
    {
        return $this->queryLog;
    }
}