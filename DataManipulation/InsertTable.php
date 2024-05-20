<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

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
            }

            // If the row is not an associative array ['value1', 'value2', ...]
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


    public function build(): string
    {
        // Get the query log data
        $queryLog = $this->getQueryLog();
        // Check if there's data to insert
        if (empty($queryLog['data'])) {
            throw new \InvalidArgumentException('No data to insert.');
        }

        // Initialize query components.
        $query = "INSERT INTO " . $queryLog['table'];
        // Array to store column names.
        $columns = [];
        // Array to store values
        $values = [];

        // Handle multiple insert rows
        if (count($queryLog['data']) > 1) {
            foreach ($queryLog['data'] as $rowIndex => $rowData) {
                $rowColumns = [];
                $rowValues = [];

                foreach ($rowData as $column => $value) {
                    $rowColumns[] = $column; // Add the column name

                    if ($this->isGoDirect()) {
                        // Direct execution - sanitize values and add directly
                        $rowValues[] = "'" . $this->sanitizeValue($value) . "'";
                    } else {
                        // Prepared statements - add placeholders and bind parameters
                        $bindIndex = $this->getBindIndexStarter() + $rowIndex;
                        $rowValues[] = ":$column$bindIndex";
                        $this->updateBindParameters("$column$bindIndex", $value);
                    }
                }

                $columns = $rowColumns; // Use the columns from the first row (assuming consistent columns)
                $values[] = "(" . implode(', ', $rowValues) . ")"; // Add values for the current row
            }
        } else {
            // Handle single insert row
            foreach ($queryLog['data'][0] as $column => $value) {
                $columns[] = $column; // Add the column name

                if ($this->isGoDirect()) {
                    // Direct execution - sanitize values and add directly
                    $values[] = "'" . $this->sanitizeValue($value) . "'";
                } else {
                    // Prepared statements - add placeholders and bind parameters
                    $bindIndex = $this->getBindIndexStarter();
                    $values[] = ":$column$bindIndex";
                    $this->updateBindParameters("$column$bindIndex", $value);
                }
            }
        }

        // Assemble the query finally to return.
        $query .= " (" . implode(', ', $columns) . ") VALUES " . implode(', ', $values);
        return $query;
    }
}