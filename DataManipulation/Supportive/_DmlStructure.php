<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive;

use NGFramer\NGFramerPHPSQLBuilder\_Builder;

abstract class _DmlStructure extends _Builder
{
    private array $structure;
    protected function __construct(string $structureType, string $structureValue)
    {
        if (empty($structureType)) {
            throw new \Exception('Structure type cannot be empty. Please provide a structure type.');
        }
        if (empty($structureValue)) {
            throw new \Exception("$structureType name cannot be empty. Please provide a structure value.");
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