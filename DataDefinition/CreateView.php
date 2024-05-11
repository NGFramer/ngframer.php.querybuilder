<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive\_DdlView;

class CreateView extends _DdlView
{
    // Construct function from parent class.
    // Location: AlterTable => _DdlTableColumn => _DdlTable.
    // __construct($tableName) function.
    public function __construct(string $viewName)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'createView');
    }




    // Main function for the class AlterView.
    public function select(string $rawSelectQuery): self
    {
        $this->addToQueryLogDeep('select', $rawSelectQuery);
        return $this;
    }




    // Builder function for the class.
    public function build(): string
    {
        $queryLog = $this->getQueryLog();
        if ($queryLog[0]['action'] == 'createView'){
            $query = "CREATE VIEW " . $this->getView() . " AS ";
            if (isset($queryLog[0]['select'])){
                $query .= $queryLog[0]['select'];
            } else {
                throw new \Exception("SelectTable query has not been passed. Pass an raw select query to create an view.");
            }
        } else {
            throw new \Exception("Something went wrong. Please look at the documentation for more information.");
        }
        return $query;
    }
}