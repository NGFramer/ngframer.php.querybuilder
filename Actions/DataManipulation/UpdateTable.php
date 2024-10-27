<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;
use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;

final class UpdateTable extends StructureTable
{
    /**
     * Use the following traits.
     */
    use WhereTrait;
    use LimitTrait;


    /**
     * This sets the tableName and the action to the actionLog.
     * @param string $table
     * @throws SqlServicesException
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
     * @return UpdateTable .
     * @throws SqlServicesException
     */
    public function update(array $updateData): self
    {
        // Check if the updateData is on the following formats.
        // method01 = update(['column', 'value', 'type'], ['column', 'value', 'type'], ['column', 'value', 'type'], ...);
        // method02 = update(['column' => ['value', 'type']], ['column' => ['value', 'type']], ['column' => ['value', 'type']], ...);
        // method03 = update(['column' => 'value', 'column' => 'value', 'column' => 'value', ...])

        // Check if updateData is empty.
        if (empty($updateData)) {
            throw new SqlServicesException('No data passed to update.', 5003013, 'sqlservices.noDataPassedToUpdate');
        }

        // Check if the updateData is an associative array.
        if (ArrayTools::isAssociative($updateData)) {
            // Loop through the updateData columns to get the data.
            foreach ($updateData as $column => $value) {
                if (is_array($value)) {
                    // Method02 starts.
                    $this->actionLog['update'][] = [
                        'column' => $column,
                        'value' => $value['value'] ?? $value[0] ?? throw new SqlServicesException('Value must be defined for updating.', 5001005, 'sqlservices.updateValueNotDefined'),
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
                    'column' => $column['column'] ?? $column[0] ?? throw new SqlServicesException('Column must be defined for updating.', 5001004, 'sqlservices.updateColumnNotDefined'),
                    'value' => $column['value'] ?? $column[1] ?? throw new SqlServicesException('Value must be defined for updating.', 5001014, 'sqlservices.updateValueNotDefined'),
                    'type' => $column['type'] ?? $column[2] ?? 'string'
                ];
                // Method01 ends.
            }
            throw new SqlServicesException('Invalid $updateData passed in update function', 5003015, 'sqlservices.invalidUpdateData');
        }

        return $this;
    }
}