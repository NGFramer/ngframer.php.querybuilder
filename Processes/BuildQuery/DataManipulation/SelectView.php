<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;

/**
 * Clone class of the class SelectTable.
 */

class SelectView
{
    /***
     * Use the following traits.
     */
    use WhereTrait;
    use SortByTrait;
    use GroupByTrait;
    use OffsetTrait;
    use LimitTrait;


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
        $columns = $actionLog['select'];
        // Get the table to select from.
        $view = $actionLog['view'];

        // Start building the query.
        $query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $view;

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

        // Add the limit clause.
        if (isset($actionLog['limit'])) {
            $query .= $this->limit($actionLog['limit']);
        }

        // TODO: Add logic to build the limit, etc.

        // Return query.
        return ['query' => $query];
    }
}