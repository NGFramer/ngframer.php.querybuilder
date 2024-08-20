<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureView;

final class CreateView extends StructureView
{
    /**
     * This will add viewName and action to actionLog.
     * @param string $view
     * @throws SqlServicesException
     */
    public function __construct(string $view)
    {
        parent::__construct($view);
        $this->setAction('createView');
        return $this;
    }

    /**
     * This sets the source of the view.
     * Source means the select query that will be used to create the view.
     * @throws SqlServicesException
     */
    public function source(string $sourceQuery): CreateView
    {
        $this->addToActionLog('source', $sourceQuery);
        return $this;
    }
}