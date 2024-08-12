<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\_Structure;

use Exception;

abstract class StructureView extends Structure
{
    /**
     * This class extends on the structure class.
     * @param string $view
     * @throws Exception
     */
    public function __construct(string $view)
    {
        // This will take in the structure name ($viewName).
        parent::__construct('view', $view);
    }
}