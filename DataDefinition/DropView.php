<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive\_DdlView;

class DropView extends _DdlView
{
    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $viewName)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'dropView');
        // Set the action.
        $this->setAction();
    }


    // Set the action for the table.
    protected function setAction($action = null): void
    {
        parent::setAction("dropView");
    }


    // Main function for the class AlterView.
    // Main function drop not required, the constructor did everything required.


    // Builder function for the class.
    public function buildQuery(): string
    {
        return "DROP VIEW " . $this->getView();
    }
}