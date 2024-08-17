<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;

class SelectTable
{
    /**
     * Use the following traits.
     */
    use WhereTrait;


    /**
     * Array to store the actionLog.
     * @var array|null
     */
    private ?array $actionLog;


    /**
     * Function that updates the actionLog.
     * @param array $actionLog
     * @return $this
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
        return $this;
    }


    /**
     * This function builds the select query from the actionLog.
     * @return string[]
     * @throws Exception
     */
    public function build(): array
    {
        // Get the actionLog.
        $actionLog = $this->actionLog;
        // Get the fields to capture (select).
        $columns = $actionLog['columns'];
        // Get the table to select from.
        $table = $actionLog['table'];

        // Start building the query.
        $query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $table;

        // Add the where clause.
        if (isset($actionLog['where'])) {
            $query .= $this->where($actionLog['where']);
        }

        // TODO: Add logic to build the limit, sortBy, groupBy, etc.

        // Return query.
        return ['query' => $query];
    }
}