<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes;

use Exception;
use NGFramer\NGFramerPHPDbServices\Database;

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


    /**
     * @throws Exception
     */
    public function execute(): Database
    {
        // Get the actionLog.
        $queryLog = $this->queryLog;

        // Check if the queryLog is empty.
        if (empty($queryLog)) {
            throw new Exception('Empty queryLog passed, modify the query to continue.');
        }

        // Prepare the query. Everything will be executed under prepared method.
        if (empty($queryLog['query'])) {
            throw new Exception('Empty query passed, modify the query to continue.');
        }
        Database::getInstance()->prepare($queryLog['query']);

        // Only if the bindings are available.
        if (!empty($queryLog['bindings'])) {
            Database::getInstance()->bindValues($queryLog['bindings']);
        }

        // Now execute the query.
        return Database::getInstance()->execute();
    }
}