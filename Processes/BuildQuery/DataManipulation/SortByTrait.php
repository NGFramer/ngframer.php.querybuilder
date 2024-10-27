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
            throw new SqlServicesException('Empty sortInstructions asked, modify the query to continue.', 5002005, 'sqlservices.noSortInstructions');
        }

        // Loop through the sorting instructions.
        foreach ($sortInstructions as $sortInstruction) {
            if (empty($sortInstruction)) {
                throw new SqlServicesException('Empty sortInstruction asked, modify the query to continue.', 5002006, 'sqlservices.noSortInstruction');
            } else {
                $columnName = $sortInstruction['column'] ?? $sortInstruction[0] ?? null;
                $sortOrder = strtoupper($sortInstruction['order']) ?? strtoupper($sortInstruction[1]) ?? null;

                // Check if the column name and sort order are valid.
                if (empty($columnName) || empty($sortOrder)) {
                    throw new SqlServicesException('Empty columnName or sortOrder asked, modify the query to continue.', 5002007, 'sqlservices.noColumnNameOrSortOrder');
                } elseif (!in_array($sortOrder, ['ASC', 'DESC'])) {
                    throw new SqlServicesException('Invalid sortOrder asked, modify the query to continue.', 5002008, 'sqlservices.invalidSortOrder');
                } else {
                    $sortByStrings[] = $columnName . ' ' . $sortOrder;
                }
            }
        }
        return ' ORDER BY ' . implode(', ', $sortByStrings);
    }
}