<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive;

abstract class _DdlView extends _DdlStructure
{
    public function __construct(string $viewName)
    {
        parent::__construct('view', $viewName);
    }

    
    public function getView(): string
    {
        return $this->getStructureValue();
    }
}