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
            throw new SqlServicesException("Structure type must be 'view' or 'table'", 5047001, 'sqlservices.actions.structure.invalidStructure');
        }

        // Check if the structure value is empty.
        if (empty($structureValue)) {
            throw new SqlServicesException("$structureType name cannot be empty.", 5047002, 'sqlservices.actions.structure.emptyStructure');
        }

        // Update the structure type and structure value to the action log.
        $this->structure = [
            'type' => $structureType,
            'value' => $structureValue
        ];

        // Add the structure details to the action log.
        $structureType = $this->structure['type'];
        $structureValue = $this->structure['value'];
        $this->addToActionLog($structureType, $structureValue);
    }
}
