<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation\Supportive\Bindings;
use NGFramer\NGFramerPHPSQLServices\Utilities\ArrayTools;
use NGFramer\NGFramerPHPSQLServices\Utilities\ValueSanitizer;

class InsertTable
{
    /**
     * Use the following for binding functions.
     */
    use Bindings;


    /**
     * Variable to store actionLog.
     * @var array
     */
    private array $actionLog;


    /**
     * Variable to store the formulated query and bindings.
     * @var array|null
     */
    private ?array $queryLog;


    /**
     * Constructor function.
     * @param array $actionLog
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    /**
     * @throws SqlServicesException
     */
    public function build(): array
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
                throw new SqlServicesException('The data you\'re trying to insert must be array.', 5002009);
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
                        throw new SqlServicesException('The column name must be string.', 5002010);
                    }
                    $columnNames[] = ValueSanitizer::sanitizeString($columnName);
                    // Create binding name, and bind the value.
                    $bindingName = $columnName . '_' . $this->getBindingIndex();
                    $this->addBinding($bindingName, $columnValue);
                    // Use the bind name in the query.
                    $columnValues[] = $bindingName;
                }
                // Now, build the remaining part of the query.
                if (count($columnNames) > 1) {
                    $query .= '(' . implode(', ', $columnNames) . ') VALUES (' . implode(', ', $columnValues) . ')';
                } else {
                    $query .= '(' . implode('', $columnNames) . ') VALUES (' . implode('', $columnValues) . ')';
                }
            } else {
                // Define binding names to save binding values.
                $bindingNames = [];
                // Loop through the insertDatum to get data from single column.
                foreach ($insertDatum as $columnValue) {
                    // Create binding name, and bind the value.
                    $bindingName = $this->getBindingIndex();
                    $this->addBinding($bindingName, $columnValue);
                    // Use the bind name in the query.
                    $bindingNames[] = $bindingName;
                }
                // If the insertData is not an associative array, then it is an array of values.
                if (count($bindingNames) > 1) {
                    $query .= ' VALUES (' . implode(', ', $bindingNames) . ')';
                } else {
                    $query .= ' VALUES (' . implode('', $bindingNames) . ')';
                }
            }

            // Add the query to the array.
            $insertQueries[] = $query;
        }

        // Count the number of queries.
        $count = count($insertQueries);

        // Build the query and return the query built.
        $this->queryLog['query'] =  $count > 1 ? implode('; ', $insertQueries) : $insertQueries[0];
        return $this->queryLog;
    }

}