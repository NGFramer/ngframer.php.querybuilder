<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions;

use Exception;
use NGFramer\NGFramerPHPDbServices\Database;
use NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\BuildQuery;
use NGFramer\NGFramerPHPSQLServices\Processes\ExecuteAction;
use NGFramer\NGFramerPHPSQLServices\Processes\LogAction;

abstract class LogBase
{
    /**
     * Use the utility trait for utility functions.
     */
    use UtilityTrait;


    /**
     * The only variable which will be used in all the action classes.
     */
    protected array $actionLog = [];


    /**
     * This will call the LogAction class's constructor & log function.
     * @return bool
     */
    protected function log(): bool
    {
        $logAction = new LogAction($this->actionLog);
        return $logAction->log();
    }


    /**
     * This will call the BuildQuery class's constructor & build function.
     * @return array
     * @throws Exception
     */
    protected function build(): array
    {
        // Step 1. Build the queryLog.
        $buildAction = new BuildQuery($this->actionLog);
        return $buildAction->build();
    }


    /**
     * This will call the ExecuteQuery class's constructor & execute function.
     * @return Database
     * @throws Exception
     */
    protected function execute(): Database
    {
        // Step 1. Build the queryLog.
        $buildAction = new BuildQuery($this->actionLog);
        $queryLog = $buildAction->build();
        // Step 2. Execute the queryLog.
        $executeAction = new ExecuteAction($this->$queryLog);
        return $executeAction->execute();
    }
}