<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive;

abstract class _DmlTable extends _DmlStructure
{
    public function __construct(string $tableName)
    {
        parent::__construct('table', $tableName);
    }

    
    public function getTable(): string
    {
        return $this->getStructureValue();
    }
}