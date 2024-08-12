<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\_Structure;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\LogBase;

abstract class Structure extends LogBase
{
    protected array $structure;

    /**
     * This function sets the structure type and value for the structure.
     * @param string $structureType
     * @param string $structureValue
     * @throws Exception
     */
    public function __construct(string $structureType, string $structureValue)
    {
        // Check if the structure type is view or table.
        if (!$structureType == 'view' && !$structureType == 'table') {
            throw new Exception("Structure type must be 'view' or 'table'");
        }

        // Check if the structure value is empty.
        if (empty($structureValue)) {
            throw new Exception("$structureType name cannot be empty");
        }

        // Update the structure type and structure value to the action log.
        $this->structure = [
            'type' => $structureType,
            'value' => $structureValue
        ];
    }
}