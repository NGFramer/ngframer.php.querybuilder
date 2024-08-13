<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataDefinition;

use Exception;

/**
 * Let's say this is the duplicate of the class DropTable.
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
     * @throws Exception
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