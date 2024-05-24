<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlView;

class RenameView extends _DdlView
{
    // Construct function from parent class.
    // Location: RenameView => _DdlView.
    // __construct($viewName) function.
    public function __construct(string $viewName)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'renameView');
    }


    // Main function for the class drop.
    // Function drop not required, the constructor did everything required.


    // Function to build the query.
    public function build(): string
    {
        return "";
    }
}