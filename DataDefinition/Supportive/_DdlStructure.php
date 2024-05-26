<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Supportive;

use NGFramer\NGFramerPHPException\exception\SqlBuilderException;
use NGFramer\NGFramerPHPSQLBuilder\_Builder;

abstract class _DdlStructure extends _Builder
{
    private array $structure;


    protected function __construct(string $structureType, string $structureValue)
    {
        if (empty($structureType)) {
            throw new SqlBuilderException('Structure type cannot be empty. Please provide a structure type.', 500, null);
        }
        if (empty($structureValue)) {
            throw new SqlBuilderException("$structureType name cannot be empty. Please provide a structure value.", 500, null);
        }
        $this->setStructure($structureType, $structureValue);
    }


    protected function setStructure(string $structureType, string $structureValue): void
    {
        $this->structure['type'] = $structureType;
        $this->structure['value'] = $structureValue;
    }
    

    protected function getStructureValue(): string
    {
        return $this->structure['value'];
    }
}