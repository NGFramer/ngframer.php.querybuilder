<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;

trait SortByTrait
{
    /**
     * @throws Exception
     */
    public function sortBy(array ...$sortInstructions): string
    {
        $sortByStrings = [];
        if (empty($sortInstructions)) {
            throw new Exception('InvalidArgumentException, Empty sortInstructions asked, modify the query to continue.');
        }

        // Loop through the sorting instructions.
        foreach ($sortInstructions as $sortInstruction) {
            if (empty($sortInstruction)) {
                throw new Exception('InvalidArgumentException, Empty sortInstruction asked, modify the query to continue.');
            } else {
                $columnName = $sortInstruction['column'] ?? $sortInstruction[0] ?? null;
                $sortOrder = strtoupper($sortInstruction['order']) ?? strtoupper($sortInstruction[1]) ?? null;

                // Check if the column name and sort order are valid.
                if (empty($columnName) || empty($sortOrder)) {
                    throw new Exception('InvalidArgumentException, Empty columnName or sortOrder asked, modify the query to continue.');
                } elseif (!in_array($sortOrder, ['ASC', 'DESC'])) {
                    throw new Exception('InvalidArgumentException, Invalid sortOrder asked, modify the query to continue.');
                } else {
                    $sortByStrings[] = $columnName . ' ' . $sortOrder;
                }
            }
        }
        return ' ORDER BY ' . implode(', ', $sortByStrings);
    }
}