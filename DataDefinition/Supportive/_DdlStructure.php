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
            throw new SqlBuilderException('Structure type cannot be empty. Please provide a structure type.', 500, ['ddl_structureType_notDefined', 0x1]);
        }
        if (empty($structureValue)) {
            throw new SqlBuilderException("$structureType name cannot be empty. Please provide a structure value.", 500, ['ddl_structureValue_notDefined', 0x2]);
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

    public function build(): array
    {
        // Get the build Log and build the action.
        $buildLog = $this->buildLog();
        $action = $buildLog['action'];
        // Return the response.
        return [
            'success' => true,
            'status_code' => 200,
            'response' => [
                'action' => $action,
                'query' => $this->buildQuery()
            ],
        ];
    }
}