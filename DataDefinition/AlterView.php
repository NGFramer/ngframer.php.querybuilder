<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlView;

class AlterView extends _DdlView
{
    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $viewName)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'alterView');
    }


    // Main function for the class AlterView.
    public function select(string $rawSelectQuery): self
    {
        $this->addToQueryLogDeep('select', $rawSelectQuery);
        return $this;
    }


    // Build function for the class AlterView.
    public function build(): string
    {
        // Get the queryLog from the class.
        $queryLog = $this->queryLog;
        // Return the query that has been built.
        return "ALTER VIEW {$queryLog['view']} AS {$queryLog['select']}";
    }
}