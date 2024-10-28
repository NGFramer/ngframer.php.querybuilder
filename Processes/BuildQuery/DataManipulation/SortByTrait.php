<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

trait SortByTrait
{
    /**
     * @throws SqlServicesException
     */
    public function sortBy(array ...$sortInstructions): string
    {
        $sortByStrings = [];
        if (empty($sortInstructions)) {
            throw new SqlServicesException('Empty sortInstructions asked, modify the query to continue.', 5043001, 'sqlservices.processes.sortBy.noInstruction');
        }

        // Loop through the sorting instructions.
        foreach ($sortInstructions as $sortInstruction) {
            if (empty($sortInstruction)) {
                throw new SqlServicesException('Empty sortInstruction asked, modify the query to continue.', 5043002, 'sqlservices.processes.sortBy.empty');
            } else {
                $columnName = $sortInstruction['column'] ?? $sortInstruction[0] ?? null;
                $sortOrder = strtoupper($sortInstruction['order']) ?? strtoupper($sortInstruction[1]) ?? null;

                // Check if the column name and sort order are valid.
                if (empty($columnName) || empty($sortOrder)) {
                    throw new SqlServicesException('Empty columnName or sortOrder asked, modify the query to continue.', 5043003, 'sqlservices.processes.sortBy.lackingValues');
                } elseif (!in_array($sortOrder, ['ASC', 'DESC'])) {
                    throw new SqlServicesException('Invalid sortOrder asked, modify the query to continue.', 5043004, 'sqlservices.processes.sortBy.invalidSortOrder');
                } else {
                    $sortByStrings[] = $columnName . ' ' . $sortOrder;
                }
            }
        }
        return ' ORDER BY ' . implode(', ', $sortByStrings);
    }
}