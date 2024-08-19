<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes;

final class ExecuteAction
{
    /**
     * Variable to store the queryLog.
     * @var array|null
     */
    private ?array $queryLog;


    /**
     * @param array $queryLog
     * @return void
     */
    public function __construct(array $queryLog)
    {
        $this->queryLog = $queryLog;
    }


    public function execute(): mixed
    {
        // Get the actionLog.
        $actionLog = $this->queryLog;

        // Implement the execute method.
        // TODO: Implement execute() method.

        // Return the execution result.
        // TODO: Change the return type if applicable.
        return [];
    }
}