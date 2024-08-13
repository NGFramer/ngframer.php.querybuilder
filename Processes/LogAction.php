<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes;

final class LogAction
{
    /**
     * Variable to store the actionLog.
     * @var null|array
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


    public function log(): bool
    {
        // Get the action Log.
        $actionLog = $this->actionLog;

        // Implement methods to log here.
        // TODO: Implement the methods to log the actionLog.

        // Return if the log was successful or not.
        return true;
    }
}