<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureView;

final class DropView extends StructureView
{
    /**
     * This will add viewName and action to the actionLog.
     * @param string $view
     * @throws SqlServicesException
     */
    public function __construct(string $view)
    {
        parent::__construct($view);
        $this->setAction('dropView');
        return $this;
    }
}