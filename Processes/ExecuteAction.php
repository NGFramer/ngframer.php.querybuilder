<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes;

final class ExecuteAction
{
    /**
     * Variable to store the actionLog.
     * @var array|null
     */
    private ?array $actionLog;


    /**
     * @param array $actionLog
     * @return void
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    public function execute(): mixed
    {
        // Get the actionLog.
        $actionLog = $this->actionLog;

        // Implement the execute method.
        // TODO: Implement execute() method.

        // Return the execution result.
        // TODO: Change the return type if applicable.
        return [];
    }
}