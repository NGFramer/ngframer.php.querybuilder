<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive;

abstract class _DdlTable extends _DdlStructure
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