<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes;

use Exception;
use NGFramer\NGFramerPHPExceptions\exceptions\BaseException;
use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
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
     * @throws SqlServicesException
     */
    public function execute(): Database
    {
        // Get the actionLog.
        $queryLog = $this->queryLog;

        // Check if the queryLog is empty.
        if (empty($queryLog)) {
            throw new SqlServicesException('Empty queryLog passed, modify the query to continue.', 5024001, 'sqlservices.processes.executeAction.emptyQueryLog');
        }

        // Prepare the query. Everything will be executed under prepared method.
        if (empty($queryLog['query'])) {
            throw new SqlServicesException('Empty query passed, modify the query to continue.', 5024002, 'sqlservices.processes.executeAction.emptyQuery');
        }

        // Convert the exception to SqlServicesException.
        try {
            Database::getInstance()->prepare($queryLog['query']);

            // Only if the bindings are available.
            if (!empty($queryLog['bindings'])) {
                Database::getInstance()->bindValues($queryLog['bindings']);
            }

            // Now execute the query.
            return Database::getInstance()->execute();
        } catch (BaseException $exception) {
            throw new SqlServicesException($exception->getMessage(), $exception->getCode(), $exception->getLabel(), $exception);
        }
    }
}