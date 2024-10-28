<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

class AlterTable
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
        $query = "ALTER TABLE `$tableName`";

        // Column definitions, foreign keys and indexes.
        $columnAdditions = [];
        $columnUpdates = [];
        $columnDrops = [];

        // Loop through the columns and add them to the query.
        foreach ($columns as $column) {

            // Check for the action of the column.
            if ($column['action'] == 'addColumn') {
                $columnAdditions[] = $this->buildColumnAdd($column);
            } elseif ($column['action'] == 'updateColumn') {
                $columnUpdates[] = $this->buildColumnUpdate($column);
            } elseif ($column['action'] == 'dropColumn') {
                $columnDrops[] = $this->buildColumnDrop($column);
            } else {
                throw new SqlServicesException('Invalid action for the column.', 5027001, 'sqlservices.proceses.alterTable.invalidColumnAction');
            }
        }

        // Form the finalized query.
        $query .= ' ' . implode(', ', $columnAdditions) . ' ' . implode(', ', $columnUpdates) . ' ' . implode(', ', $columnDrops);

        // Return the query built.
        return ['query' => $query];
    }


    /**
     * Build the SQL for adding a column.
     * @param array $column
     * @return string
     * @throws SqlServicesException
     */
    private function buildColumnAdd(array $column): string
    {
        // Check for type and column name.
        if (!isset($column['column']) || !isset($column['type'])) {
            throw new SqlServicesException('Column must have column and type attributes.', 5027002, 'sqlservices.proceses.alterTable.attributesNotDefined');
        }
        $columnDefinition = 'ADD COLUMN `' . $column['column'] . '` ' . $column['type'];

        // Check for the length, if not available, define self from the default value or throw error.
        // TODO: Apply the above mentioned commented logic.
        if (isset($column['length'])) {
            $columnDefinition .= '(' . $column['length'] . ')';
        }

        // Check if the column can be nullable or not.
        if (isset($column['nullable'])) {
            if (!$column['nullable']) {
                $columnDefinition .= ' NOT NULL';
            } else {
                $columnDefinition .= ' NULL';
            }
        }

        // Check for the default value for the column.
        if (isset($column['default'])) {
            $columnDefinition .= " DEFAULT '" . $column['default'] . "'";
        }

        // Check for the autoIncrement attribute.
        if (isset($column['autoIncrement'])) {
            if ($column['autoIncrement']) {
                // TODO: Check if the type of column is numerical (int type) for autoincrement to be allowed.
                // TODO: Check if it is not null.
                $columnDefinition .= ' AUTO_INCREMENT';
            } else {
                throw new SqlServicesException('Dropping of auto increment not available while adding column.', 5027003, 'sqlservices.processes.alterTable.cantDropAI');
            }
        }

        // Check for unique attribute.
        if (isset($column['unique'])) {
            if ($column['unique']) {
                $columnDefinition .= ', ADD UNIQUE (`' .$column['column']. '`)';
            } else {
                throw new SqlServicesException('Dropping Unique attribute not available while adding column.', 5027004, 'sqlservices.processes.alterTable.cantDropUnique');
            }
        }

        // Check for the primary attribute.
        if (isset($column['primary'])) {
            if ($column['primary']) {
                $columnDefinition .= ", ADD PRIMARY KEY (`" . $column['column'] . "`)";
            } else {
                throw new SqlServicesException('Dropping primary key not available when adding column.', 5027005, 'sqlservices.processes.alterTable.cantDropPrimary');
            }
        }

        // Check for foreign key attribute.
        if (isset($column['foreign'])) {
            if (isset($column['foreign']['table']) && isset($column['foreign']['column'])) {
                $foreignTable = $column['foreign']['table'];
                $foreignColumn = $column['foreign']['column'];
                $columnDefinition .= ", FOREIGN KEY (`" . $column['column'] . "`) REFERENCES `" . $foreignTable . "`(`" . $foreignColumn . "`)";
            } else {
                throw new SqlServicesException('Pass the table and column name to define foreign key.', 5027006, 'sqlservices.processes.alterTable.missingFkArguments');
            }
        }

        // Check for index.
        if (isset($column['index'])) {
            if ($column['index']) {
                $columnDefinition .= ', ADD INDEX (`' . $column['column'].  '`)';
            } else {
                throw new SqlServicesException('Dropping index key not available when adding column.', 5027007, 'sqlservices.processes.alterTable.cantDropIndex');
            }
        }

        return $columnDefinition;
    }


    /**
     * This function builds the update column part of the SQL Alter Query.
     * @param array $column
     * @return string
     * @throws SqlServicesException
     */
    private function buildColumnUpdate(array $column): string
    {
        // Check for the column attribute.
        if (!isset($column['column'])) {
            throw new SqlServicesException('Column must be defined for updating the column.', 5027008, 'sqlservices.processes.alterTable.columnNotDefined');
        }
        $columnDefinition = "MODIFY COLUMN `" . $column['column'] . "`";

        // Check for the column type.
        if (isset($column['type'])) {
            $columnDefinition .= ' ' . $column['type'];
            // Check for the length, if not available, define self from the default value or throw error.
            if (isset($column['length'])) {
                $columnDefinition .= '(' . $column['length'] . ')';
            } else {
                throw new SqlServicesException('Column length must be defined for changed column data type.', 5027009, 'sqlservices.processes.alterTable.lengthNotDefined');
            }
        }

        // Check if the column can be nullable or not.
        if (isset($column['nullable'])) {
            if (!$column['nullable']) {
                $columnDefinition .= ' NOT NULL';
            } else {
                $columnDefinition .= ' NULL';
            }
        }

        // Check for default value.
        if (isset($column['default'])) {
            $columnDefinition .= " DEFAULT '" . $column['default'] . "'";
            // TODO: Add a method to drop the default value.
        }

        // Handle unique key.
        if (isset($column['unique'])) {
            if ($column['unique']) {
                $columnDefinition .= ', ADD UNIQUE (`unq_' . $column['column'] . '`)';
            } else {
                $columnDefinition .= ', DROP INDEX `unq_' . $column['column'] . '`';
            }
        }

        // Handle foreign key.
        if (isset($column['foreign'])) {
            if (isset($column['foreign']['table']) && isset($column['foreign']['column'])) {
                $foreignTable = $column['foreign']['table'];
                $foreignColumn = $column['foreign']['column'];
                $columnDefinition .= ", ADD FOREIGN KEY (`" . $column['column'] . "`) REFERENCES `" . $foreignTable . "`(`" . $foreignColumn . "`)";
            } else {
                throw new SqlServicesException('Pass the table and column name to define foreign key.', 5027010, 'sqlservices.processes.alterTable.missingFkArguments.2');
            }
            // TODO: Add a way to drop foreign constraint.
        }

        // Handle index.
        if (isset($column['index'])) {
            if ($column['index']) {
                $columnDefinition .= ', ADD INDEX (`' . $column['column'] . '`)';
            } else {
                $columnDefinition .= ', DROP INDEX `' . $column['column'] . '`';
            }
        }

        // Return the query built.
        return $columnDefinition;
    }


    /**
     * This function builds the drop column part of the SQL Alter Query.
     * @param array $column
     * @return string
     */
    private function buildColumnDrop(array $column): string
    {
        return "DROP COLUMN `" . $column['column'] . "`";
    }
}


// TODO: Add support for data types that has not been considered.
// TODO: Add support for ENUM Data type.