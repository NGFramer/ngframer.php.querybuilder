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

        // Prepare the initial query
        $query = "INSERT INTO $table ";

        // Store the column names and their values on variables.
        $columnNames = [];
        $columnValues = [];
        $valueTypes = [];

        // Check if first entry has column name or not.
        if (isset($insertData[0]) and isset($insertData[0]['column'])) {

            // Loop through the insertData to get data from single row.
            foreach ($insertData as $insertDatum) {

                // Check if the insertDatum is an array or not.
                if (!is_array($insertDatum) or !ArrayTools::isAssociative($insertDatum)) {
                    throw new SqlServicesException('Invalid format of data passed to insert.', 5002009);
                }

                // Get the column name, column value, and value type.
                $columnName = $insertDatum['column'] ?? throw new SqlServicesException('Column must be defined for inserting.', 5002010);
                $columnValue = $insertDatum['value'] ?? throw new SqlServicesException('Value must be defined for inserting.', 5002011);
                $valueType = $insertDatum['type'] ?? 'string';

                // Check if the columnName is a string, and column value is also string.
                if (!is_string($columnName)) {
                    throw new SqlServicesException('The column name must be string.', 5002010);
                }

                // Sanitize the column name.
                $columnNames[] = ValueSanitizer::sanitizeString($columnName);

                // Create binding name, and bind the value.
                $bindingName = $columnName . '_' . $this->getBindingIndex();
                $this->addBinding($bindingName, $columnValue);

                // Use the bind name in the query.
                $columnValues[] = ':' . $bindingName;
            }

            // Now, build the remaining part of the query.
            if (count($columnNames) > 1) {
                $query .= '(`' . implode('`, ', $columnNames) . '`) VALUES (' . implode(', ', $columnValues) . ')';
            } else {
                $query .= '(`' . implode(' ', $columnNames) . '`) VALUES (' . implode('', $columnValues) . ')';
            }
        } else {
            // Check if the insertDatum is an array or not.
            if (!is_array($insertDatum) or !ArrayTools::isAssociative($insertDatum)) {
                throw new SqlServicesException('Invalid format of data passed to insert.', 5002009);
            }

            // Get the column value and value type.
            $columnValue = $insertDatum['value'] ?? throw new SqlServicesException('Value must be defined for inserting.', 5002011);
            $valueType = $insertDatum['type'] ?? 'string';

            // Create binding name, and bind the value.
            $bindingName = 'column' . '_' . $this->getBindingIndex();
            $this->addBinding($bindingName, $columnValue);

            // Use the bind name in the query.
            $columnValues[] = ':' . $bindingName;

            // Now, build the remaining part of the query.
            if (count($columnNames) > 1) {
                $query .= 'VALUES (' . implode(', ', $columnValues) . ');';
            } else {
                $query .= 'VALUES (' . implode('', $columnValues) . ');';
            }
        }
        
        // Build the query and return the query built.
        $this->queryLog['query'] = $query;
        return $this->queryLog;
    }
}