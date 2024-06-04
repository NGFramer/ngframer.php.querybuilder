<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class InsertTable extends _DmlTable
{
    // Construct the InsertTable Class.
    public function __construct(string $tableName, array ...$data)
    {
        // Just set the table name.
        parent::__construct($tableName);
        // Add the action and the table name to the query log.
        $this->addQueryLog('table', $tableName, 'insertData');
        // Call the insert data function.
        $this->insert(...$data);
    }


    // Insert data function for the class.
    // Only one row of the data will be allowed for the
    public function insert(array ...$data): self
    {
        // Loop through the data to process each row.
        // An array inside the $data will also be an array of values.
        foreach ($data as $row) {

            // Initialize the row data.
            $rowData = [];

            // If the row is an associative array ['column1' => 'value1', 'column2' => 'value2', ...]
            if ($this->isAssocArray($row)) {
                // Loop through the row data to process each column
                foreach ($row as $columnName => $columnValue) {
                    $rowData[] = ['column' => $columnName, 'value' => $columnValue];
                }
            } // If the row is not an associative array ['value1', 'value2', ...]
            else {
                // If the row is an array of values (assuming column order)
                foreach ($row as $columnValue) {
                    $rowData[] = ['value' => $columnValue];
                }
            }

            // Add the row data to queryLog.
            $this->addToQueryLogDeepArray('data', $rowData);
        }

        // Return instance of the class for object chaining.
        return $this;
    }


    // Go direct function for where conditions.
    public function goDirect(): self
    {
        // Get the goDirect function from parent.
        parent::goDirect();
        // Return instance for object chaining.
        return $this;
    }


    public function buildQuery(): string
    {
        // Get the query log data
        $queryLog = $this->getQueryLog();

        // Check if there's data to insert
        if (empty($queryLog['data'])) {
            throw new SqlBuilderException('InvalidArgumentException, No data to insert.', 0, null, 500, ['error_type'=>'dmlInsert_invalid_data']);
        }

        // Array to store all generated queries
        $queries = [];

        // Handle multiple insert rows
        foreach ($queryLog['data'] as $rowData) {

            // Initialize query components
            $query = "INSERT INTO " . $queryLog['table'];
            $columns = [];
            $values = [];

            // Check if the first row element has a 'column' key to determine if column names are provided
            $hasColumnName = isset($rowData[0]['column']);

            // Loop inside the row's columns (fields)
            foreach ($rowData as $rowComponent) {

                // Get bind index for the columns (field)
                $bindIndex = $this->getBindIndexStarter();

                // Execution if the column name was set
                if ($hasColumnName) {
                    $column = $rowComponent['column'];
                    $value = $rowComponent['value'];
                    $columns[] = $column;

                    // Execution based on the method of execution.
                    // If not direct, use bind parameters
                    if (!$this->isGoDirect()) {
                        $values[] = ':' . $column . $bindIndex;
                        $this->updateBindParameters($column . $bindIndex, $this->sanitizeValue($value));
                    } // If direct, use the value directly
                    else $values[] = "'" . $this->sanitizeValue($value) . "'";
                } // Execution if the column name was not set
                else {
                    $value = $rowComponent['value'];

                    // Execution based on the method of execution.
                    if (!$this->isGoDirect()) {
                        $values[] = ':column' . $bindIndex;
                        $this->updateBindParameters('column' . $bindIndex, $this->sanitizeValue($value));
                    } else {
                        $values[] = "'" . $this->sanitizeValue($value) . "'";
                    }
                }
            }

            // Construct the query based on whether column names are provided.
            if ($hasColumnName) $query .= ' (' . implode(', ', $columns) . ')';
            $query .= ' VALUES (' . implode(', ', $values) . ')';

            // Get the query to be saved for later.
            $queries[] = $query;
        }

        // Combine all queries with a semicolon and return.
        return implode('; ', $queries);
    }
}