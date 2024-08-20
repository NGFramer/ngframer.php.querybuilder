<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

class TruncateTable
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

        // Start making the query (initial part).
        $query = "TRUNCATE TABLE `$tableName`";

        // Return the query built.
        return ['query' => $query];
    }
}