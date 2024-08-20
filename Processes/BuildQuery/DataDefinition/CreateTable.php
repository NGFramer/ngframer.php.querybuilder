<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

class CreateTable
{
    /**
     * Variable to store the actionLog.
     * @var array|null
     */
    private ?array $actionLog;


    /**
     * Constructor function.
     * @param array $actionLog
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    /**
     * This function builds the query from the action log.
     * @return array
     * @throws SqlServicesException
     */
    public function build(): array
    {
        // Get the data required.
        $actionLog = $this->actionLog;
        $tableName = $actionLog['table'];
        $columns = $actionLog['columns'];

        // Start making the query (initial part).
        $query = "CREATE TABLE `$tableName` (";

        // Column definitions, foreign keys and indexes.
        $columnDefinitions = [];
        $foreignKeys = [];
        $indexes = [];

        // Loop through the columns and add them to the query.
        foreach ($columns as $column) {
            // Check if the column has attributes.
            if (!isset($column['column']) || !isset($column['type'])) {
                throw new SqlServicesException('Column must have column and type attributes.', 5001009);
            }

            // Initialize the column definition.
            $columnDefinition = '`' . $column['column'] . '` ' . $column['type'];

            // Add the attributes.
            // Check for not null attribute.
            if (isset($column['nullable']) && !$column['nullable']) {
                $columnDefinition .= ' NOT NULL';
            }

            // Check for default attribute.
            if (isset($column['default'])) {
                $columnDefinition .= " DEFAULT '" . $column['default'] . "'";
            }

            // Check for auto increment attribute.
            if (isset($column['auto_increment']) && $column['auto_increment']) {
                $columnDefinition .= ' AUTO_INCREMENT';
            }

            // Check for primary attribute.
            if (isset($column['primary']) && $column['primary']) {
                $columnDefinition .= ' PRIMARY KEY';
            }

            // Check for unique attribute.
            if (isset($column['unique']) && $column['unique']) {
                $columnDefinition .= ' UNIQUE';
            }

            $columnDefinitions[] = $columnDefinition;

            // Check for foreign key constraints.
            if (isset($column['foreign'])) {
                if (!isset($column['foreign']['table']) || !isset($column['foreign']['column'])) {
                    throw new SqlServicesException('Foreign constraint must have foreign table and foreign column attributes.', 5001010);
                } else {
                    $foreignKeys[] = "FOREIGN KEY (`" . $column['column'] . "`) REFERENCES `" . $column['foreign']['table'] . "` (`" . $column['foreign']['column'] . "`)";
                }
            }

            // Check for index attributes.
            if (isset($column['indexes']) && $column['indexes']) {
                // Index will be named as idx_columnName.
                $indexes[] = 'INDEX `idx_' . $column['column'] . '` (`' . $column['column'] . '`)';
            }
        }

        // Now add query, columnDefinitions, foreignKeys, indexes, and closing braces.
        if (!empty($columnDefinitions)) {
            $query .= implode(', ', $columnDefinitions);
        } else {
            throw new SqlServicesException('Table must have at least one column.', 5003012);
        }
        if (!empty($foreignKeys)) {
            $query .= ', ' . implode(', ', $foreignKeys);
        }
        if (!empty($indexes)) {
            $query .= ', ' . implode(', ', $indexes);
        }
        $query .= ')';

        // Return the query built.
        return ['query' => $query];
    }
}


// TODO: Add support for data types that has not been considered.
// TODO: Add support for ENUM Data type.