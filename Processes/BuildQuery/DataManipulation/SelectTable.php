<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation\Supportive\Bindings;

class SelectTable
{
    /**
     * Use the following traits for query building.
     */
    use WhereTrait;
    use SortByTrait;
    use GroupByTrait;
    use OffsetTrait;
    use LimitTrait;


    /**
     * Use the following for binding functions.
     */
    use Bindings;


    /**
     * Array to store the actionLog.
     * @var array|null
     */
    private ?array $actionLog;


    /**
     * Variable to store the formulated query and bindings.
     * @var array|null
     */
    private ?array $queryLog;


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
     * @throws SqlServicesException
     */
    public function build(): array
    {
        // Get the actionLog.
        $actionLog = $this->actionLog;
        // Get the fields to capture (select).
        $columns = $actionLog['select'];
        // Get the table to select from.
        $table = $actionLog['table'];

        // Start building the query.
        $query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $table;

        // Add the where clause.
        if (isset($actionLog['where'])) {
            $query .= $this->where($actionLog['where']);
        }

        // Add the sortBy clause.
        if (isset($actionLog['sortBy'])) {
            $query .= $this->sortBy($actionLog['sortBy']);
        }

        // Add the groupBy clause.
        if (isset($actionLog['groupBy'])) {
            $query .= $this->groupBy($actionLog['groupBy']);
        }

        // Add the offset clause.
        if (isset($actionLog['offset'])) {
            $query .= $this->offset($actionLog['offset']);
        }

        // Add the limit clause.
        if (isset($actionLog['limit'])) {
            $query .= $this->limit($actionLog['limit']);
        }

        // Return query.
        $this->queryLog['query'] = $query;
        return $this->queryLog;
    }
}