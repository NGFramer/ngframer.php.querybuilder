<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use Exception;

class UpdateTable
{
    /**
     * Variable to store actionLog.
     * @var array
     */
    private array $actionLog;


    /**
     * Constructor function.
     * @param array $actionLog
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    /**
     * @throws Exception
     */
    public function build(): string
    {
        // Get the actionLog, table, and data.
        $actionLog = $this->actionLog;
        $table = $actionLog['table'];
        $data = $actionLog['data'];

        // For the initial part of updateQuery.
        $updateQuery = "UPDATE `" . $table . "` SET ";

        // Now look for the data to update.
        if (empty($data)) {
            throw new Exception('No data passed to update.');
        }

        // Loop and update the query.
        foreach ($data as $datum) {
            $column = $datum['column'] ?? throw new Exception('Column must be defined for updating.');
            $value = $datum['value'] ?? throw new Exception('Value must be defined for updating.');
            $updateQuery .= "`" . $column . "` = '" . $value . "', ";
        }

        // Remove the last comma and space.
        $updateQuery = substr($updateQuery, 0, -2);

        // Return the query.
        return $updateQuery;
    }

}