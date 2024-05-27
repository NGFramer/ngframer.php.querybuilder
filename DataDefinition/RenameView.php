<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlView;

class RenameView extends _DdlView
{
    // Construct function from parent class.
    // Location: RenameView => _DdlView.
    // __construct($viewName) function.
    public function __construct(string $viewName, string $newViewName)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'renameView');
        $this->addToQueryLogDeep('value', $newViewName);
    }


    // Main function for the class rename.
    // Function rename not required, the constructor did everything required.


    // Function to build the query.
    public function build(): string
    {
        // Get query log and then the table name.
        $queryLog = $this->getQueryLog();
        $oldViewName = $queryLog['value'];
        $newViewName = $queryLog['value'];
        // Start building the query and return it.
        return "ALTER TABLE `{$oldViewName}` RENAME TO `{$newViewName}`;";
    }
}