<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;

final class InsertTable extends StructureTable
{
    /**
     * This sets the tableName and the action to the actionLog.
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('insertTable');
        return $this;
    }


    /**
     * This will add insertData to the actionLog.
     * @param array $insertData . Single row data. Use multiple row data to insert multiple rows.
     * @return void
     * @throws Exception
     */
    public function insert(mixed ...$insertData): void
    {
        // Check if the insertData is on the following formats.
        // method01 = insert(['column', 'value', 'type'], ['column', 'value', 'type'], ['column', 'value', 'type'], ...);
        // method02 = insert(['column' => ['value', 'type']], ['column' => ['value', 'type']], ['column' => ['value', 'type']], ...);
        // method03 = insert(['column' => 'value', 'column' => 'value', 'column' => 'value', ...])
        // method04 = insert('value', 'value', 'value', ...)

        // Check for insertData.
        if (ArrayTools::isIndexed($insertData)) {
            if (ArrayTools::areAllArray($insertData)) {
                // Method01 starts.
                // Loop through the columns.
                foreach ($insertData as $insertColumn) {
                    $this->actionLog['insert'][] = [
                        'column' => $insertColumn['column'] ?? $insertColumn[0] ?? throw new Exception('Column must be defined for inserting.'),
                        'value' => $insertColumn['value'] ?? $insertColumn[1] ?? throw new Exception('Value must be defined for inserting.'),
                        'type' => $insertColumn['type'] ?? $insertColumn[2] ?? 'string'
                    ];
                }
                // Method01 ends.
            }
            else {
                // Method04 starts.
                foreach ($insertData as $insertDatum) {
                    $this->actionLog['insert'][] = [
                        'value' => $insertDatum,
                        'type' => 'string'
                    ];
                }
                // Method04 ends.
            }
        } else {
            foreach ($insertData as $key => $value) {
                 if (is_array($value)) {
                     // Method02 starts.
                     $this->actionLog['insert'][] = [
                         'column' => $key,
                         'value' => $value['value'] ?? $value[0] ?? throw new Exception('Value must be defined for inserting.'),
                         'type' => $value['type'] ?? $value[1] ?? 'string'
                     ];
                     // Method02 ends.
                 } else {
                     // Method03 starts.
                     $this->actionLog['insert'][] = [
                         'column' => $key,
                         'value' => $value,
                         'type' => 'string'
                     ];
                     // Method03 ends.
                 }
            }
        }
    }
}