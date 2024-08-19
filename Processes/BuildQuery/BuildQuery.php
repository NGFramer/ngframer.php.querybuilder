<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery;

use Exception;

final class BuildQuery
{
    /**
     * Variable that stores the actionLog.
     * @var array|null
     */
    private ?array $actionLog;


    /**
     * Constructor function.
     * @param array $actionLog
     * @return void
     * @throws Exception
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    /**
     * This function will teleport the actionLog to the respective class for building the query.
     * @throws Exception
     */
    public function build(): mixed
    {
        // Get the actionLog.
        $actionLog = $this->actionLog;

        // Get the action from the actionLog.
        $action = $this->getAction($actionLog);

        // Check if the action exists and check if the action is related to data definition or data manipulation or none.
        if (in_array($action, ['createTable', 'createView', 'alterTable', 'alterView', 'renameTable', 'renameView', 'truncateTable', 'dropTable', 'dropView'])) {
            $class = '\\NGFramer\\NGFramerPHPSQLServices\\Processes\\BuildQuery\\DataDefinition\\' . ucfirst($action);
        } elseif (in_array($action, ['selectTable', 'selectView', 'insertTable', 'updateTable', 'deleteTable'])) {
            $class = '\\NGFramer\\NGFramerPHPSQLServices\\Processes\\BuildQuery\\DataManipulation\\' . ucfirst($action);
        } else {
            throw new Exception('Invalid action log. Check actionLog documentation and error_log for more.');
        }

        // Instantiate the class.
        $builderClassInstance = new $class($actionLog);
        // Now, to return the built query.
        return $builderClassInstance->build();
    }


    /**
     * Function to get the action from the actionLog.
     * @param array $actionLog
     * @return string
     */
    private function getAction(array $actionLog): string
    {
        return (string)$actionLog['action'] ?? 'undefined';
    }
}