<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

class DropTable
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
     */
    public function build(): array
    {
        // Get the data required.
        $actionLog = $this->actionLog;
        $tableName = $actionLog['table'];

        // Start making the query (initial part).
        $query = "DROP TABLE `$tableName`";

        // Return the query built.
        return ['query' => $query];
    }
}