<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

final class DropTable extends StructureTable
{
    /**
     * This will add action and viewName to the actionLog.
     * @param string $view
     * @throws SqlServicesException
     */
    public function __construct(string $view)
    {
        parent::__construct($view);
        $this->setAction('dropTable');
        return $this;
    }
}