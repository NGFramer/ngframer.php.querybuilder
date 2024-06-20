<?php

namespace NGFramer\NGFramerPHPSQLServices\DataDefinition\Supportive;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLServices\_Base;

abstract class _DdlStructure extends _Base
{
    private array $structure;


    protected function __construct(string $structureType, string $structureValue)
    {
        if (empty($structureType)) {
            throw new SqlBuilderException('Structure type cannot be empty. Please provide a structure type.', 0, null, 500, ['error_type' => 'ddl_structureType_notDefined']);
        }
        if (empty($structureValue)) {
            throw new SqlBuilderException("$structureType name cannot be empty. Please provide a structure value.", 0, null, 500, ['error_type' => 'ddl_structureValue_notDefined']);
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