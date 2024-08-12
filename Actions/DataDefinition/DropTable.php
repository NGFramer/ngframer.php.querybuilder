<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

final class DropTable extends StructureTable
{
    /**
     * This will add action and viewName to the actionLog.
     * @param string $view
     * @throws Exception
     */
    public function __construct(string $view)
    {
        parent::__construct($view);
        $this->setAction('dropTable');
        return $this;
    }
}