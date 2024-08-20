<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\_Structure;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\LogBase;

abstract class Structure extends LogBase
{
    protected array $structure;

    /**
     * This function sets the structure type and value for the structure.
     * @param string $structureType
     * @param string $structureValue
     * @throws SqlServicesException
     */
    public function __construct(string $structureType, string $structureValue)
    {
        // Check if the structure type is view or table.
        if (!$structureType == 'view' && !$structureType == 'table') {
            throw new SqlServicesException("Structure type must be 'view' or 'table'", 5006001);
        }

        // Check if the structure value is empty.
        if (empty($structureValue)) {
            throw new SqlServicesException("$structureType name cannot be empty", 5006002);
        }

        // Update the structure type and structure value to the action log.
        $this->structure = [
            'type' => $structureType,
            'value' => $structureValue
        ];
    }
}