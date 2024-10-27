<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataDefinition;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

/**
 * This will only work for MySQL Server.
 * TODO: Make it work for PostgreSQL, SQL Server, Oracle, and other servers too.
 */

class RenameTable
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
        $newTableName = $actionLog['to'];

        // Start making the query (initial part).
        $query = "RENAME TABLE `$tableName` TO `$newTableName`";

        // Return the query built.
        return ['query' => $query];
    }
}