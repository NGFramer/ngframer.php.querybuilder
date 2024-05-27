<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlView;

class DropView extends _DdlView
{
    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $viewName)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'dropView');
    }


    // Main function for the class AlterView.
    // Main function drop not required, the constructor did everything required.


    // Builder function for the class.
    public function buildQuery(): string
    {
        return "DROP VIEW " . $this->getView();
    }
}