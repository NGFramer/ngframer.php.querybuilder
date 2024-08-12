<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

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
}