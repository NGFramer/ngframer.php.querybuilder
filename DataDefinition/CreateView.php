<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

use NGFramer\NGFramerPHPException\exception\SqlBuilderException;
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
        if ($queryLog[0]['action'] == 'createView') {
            $query = "CREATE VIEW " . $this->getView() . " AS ";
            if (isset($queryLog[0]['select'])) {
                $query .= $queryLog[0]['select'];
            } else {
                throw new SqlBuilderException("SelectTable query has not been passed. Pass an raw select query to create an view.", 500, ['ddlCreateView_selection_notDefined', 0x17]);
            }
        } else {
            throw new SqlBuilderException("Something went wrong. Please look at the documentation for more information.", 500, ['ddlCreateView_action_invalidOrEmpty', 0x18]);
        }
        return $query;
    }
}