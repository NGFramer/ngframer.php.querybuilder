<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

/**
 * Class AlterView
 * No need to cross-check, just the replication of CreateView class.
 * Query different is just ALTER VIEW instead of CREATE VIEW.
 */

final class AlterView extends StructureTable
{
    /**
     * This just sets the action and viewName to alter view.
     * @param string $view
     * @throws Exception
     */
    public function __construct(string $view)
    {
        parent::__construct($view);
        $this->setAction('alterView');
        return $this;
    }


    /**
     * This sets the source of the view.
     * Source means the new select query that will be used to alter the view from the previous view.
     * @throws Exception
     */
    public function source(string $newSourceQuery): AlterView
    {
        $this->addToActionLog('source', $newSourceQuery);
        return $this;
    }
}