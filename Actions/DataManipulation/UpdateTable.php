<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;

final class UpdateTable extends StructureTable
{
    /**
     * This sets the tableName and the action to the actionLog.
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('updateTable');
        return $this;
    }


    /**
     * This will add the updating data to the actionLog.
     * @param array $updateData .
     * @return void .
     * @throws Exception
     */
    public function update(array $updateData): void
    {
        // Check if the updateData is on the following formats.
        // method01 = update(['column', 'value', 'type'], ['column', 'value', 'type'], ['column', 'value', 'type'], ...);
        // method02 = update(['column' => ['value', 'type']], ['column' => ['value', 'type']], ['column' => ['value', 'type']], ...);
        // method03 = update(['column' => 'value', 'column' => 'value', 'column' => 'value', ...])

        // Check if updateData is empty.
        if (empty($updateData)) {
            throw new Exception('No data passed to update.');
        }

        // Check if the updateData is an associative array.
        if (ArrayTools::isAssociative($updateData)) {
            // Loop through the updateData columns to get the data.
            foreach ($updateData as $column => $value) {
                if (is_array($value)) {
                    // Method02 starts.
                    $this->actionLog['update'][] = [
                        'column' => $column,
                        'value' => $value['value'] ?? $value[0] ?? throw new Exception('Value must be defined for updating.'),
                        'type' => $value['type'] ?? $value[1] ?? 'string'
                    ];
                    // Method02 ends.
                } else {
                    // Method03 starts.
                    $this->actionLog['update'][] = [
                        'column' => $column,
                        'value' => $value,
                        'type' => 'string'
                    ];
                    // Method03 ends.
                }
            }
        } else {
            // Loop through the updateData to get the data.
            foreach ($updateData as $column) {
                // Method01 starts.
                $this->actionLog['update'][] = [
                    'column' => $column['column'] ?? $column[0] ?? throw new Exception('Column must be defined for updating.'),
                    'value' => $column['value'] ?? $column[1] ?? throw new Exception('Value must be defined for updating.'),
                    'type' => $column['type'] ?? $column[2] ?? 'string'
                ];
                // Method01 ends.
            }
            throw new Exception('Invalid $updateData passed in update function');
        }
    }
}