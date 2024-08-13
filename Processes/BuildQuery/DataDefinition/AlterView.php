<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataDefinition;

use Exception;

/**
 * Class AlterView
 * No need to cross-check, just the replication of CreateView class.
 * Query different is just ALTER VIEW instead of CREATE VIEW.
 */

class AlterView
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
     * @throws Exception
     */
    public function build(): array
    {
        // Get the data required.
        $actionLog = $this->actionLog;
        $viewName = $actionLog['table'];
        $sourceQuery = $actionLog['source'];

        // Now the main process of building the query.
        $query = 'ALTER VIEW `' . $viewName . '` AS ' . $sourceQuery;
        return ['query' => $query];
    }
}