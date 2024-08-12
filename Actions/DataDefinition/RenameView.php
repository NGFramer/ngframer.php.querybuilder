<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureView;

final class RenameView extends StructureView
{
    /**
     * This will add the renameView action and viewName to the actionLog.
     * @param string $view
     * @throws Exception
     */
    public function __construct(string $view)
    {
        parent::__construct($view);
        $this->setAction('renameVew');
        return $this;
    }


    /**
     * This function takes in the name to rename the view to and sets in the actionLog.
     * @param string $newViewName
     * @return RenameView
     * @throws Exception
     */
    public function to(string $newViewName): RenameView
    {
        $this->addToActionLog('to', $newViewName);
        return $this;
    }
}