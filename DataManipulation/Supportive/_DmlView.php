<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive;

abstract class _DmlView extends _DmlStructure
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