<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;
use NGFramer\NGFramerPHPSQLServices\Utilities\ValueSanitizer;

class InsertTable
{
    /**
     * Variable to store actionLog.
     * @var array
     */
    private array $actionLog;


    /**
     * Constructor function.
     * @param array $actionLog
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    /**
     * @throws Exception
     */
    public function build(): string
    {
        // Get the actionLog, table, and data.
        $actionLog = $this->actionLog;
        $table = $actionLog['table'];
        $insertData = $actionLog['insert'];

        // For conditions when insert is not one but many.
        $insertQueries = [];

        // Loop through the insertData to get data from single row.
        foreach ($insertData as $insertDatum) {
            // Prepare the initial query
            $query = "INSERT INTO $table ";

            // Check if the insertDatum is an array or not.
            if (!is_array($insertDatum)) {
                throw new Exception('The data you\'re trying to insert must be array.');
            }

            // Now check if the insertData is an associative array or not.
            if (ArrayTools::isAssociative($insertDatum)) {
                // For simplicity, let's store the data on a variable.
                $columnNames = [];
                $columnValues = [];
                // Now, loop through the insertDatum to get data from single column.
                foreach ($insertDatum as $columnName => $columnValue) {
                    // Check if the columnName is a string, and column value is also string.
                    if (!is_string($columnName)) {
                        throw new Exception('The column name must be string.');
                    }
                    $columnNames[] = ValueSanitizer::sanitizeString($columnName);
                    $columnValues[] = ValueSanitizer::sanitizeString($columnValue);
                }
                // Now, build the remaining part of the query.
                if (count($columnNames) > 1) {
                    $query .= '(' . implode(', ', $columnNames) . ') VALUES (' . implode(', ', $columnValues) . ')';
                } else {
                    $query .= '(' . implode('', $columnNames) . ') VALUES (' . implode('', $columnValues) . ')';
                }
            } else {
                // If the insertData is not an associative array, then it is an array of values.
                if (count($insertDatum) > 1) {
                    $query .= ' VALUES (' . implode(', ', $insertDatum) . ')';
                } else {
                    $query .= ' VALUES (' . implode('', $insertDatum) . ')';
                }
            }

            // Add the query to the array.
            $insertQueries[] = $query;
        }

        // Count the number of queries.
        $count = count($insertQueries);

        // Return the query built.
        return $count > 1 ? implode('; ', $insertQueries) : $insertQueries[0];
    }

}