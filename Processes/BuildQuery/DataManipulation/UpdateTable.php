<?php

namespace NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Processes\BuildQuery\DataManipulation\Supportive\Bindings;

class UpdateTable
{
    /**
     * Use the following traits for query building.
     */
    use WhereTrait;
    use LimitTrait;


    /**
     * Use the following for binding functions.
     */
    use Bindings;


    /**
     * Variable to store actionLog.
     * @var array
     */
    private array $actionLog;


    /**
     * Variable to store the formulated query and bindings.
     * @var array|null
     */
    private ?array $queryLog;


    /**
     * Constructor function.
     * @param array $actionLog
     */
    public function __construct(array $actionLog)
    {
        $this->actionLog = $actionLog;
    }


    /**
     * Builds the update query from the actionLog.
     * @return array
     * @throws SqlServicesException
     */
    public function build(): array
    {
        // Get the actionLog, table, and data.
        $actionLog = $this->actionLog;
        $table = $actionLog['table'];
        $data = $actionLog['update'];

        // For the initial part of updateQuery.
        $updateQuery = "UPDATE `" . $table . "` SET ";

        // Now look for the data to update.
        if (empty($data)) {
            throw new SqlServicesException('No data passed to update.', 5044001, 'sqlservices.processes.updateTable.noDataToUpdate');
        }

        // Loop and update the query.
        foreach ($data as $datum) {
            $column = $datum['column'] ?? throw new SqlServicesException('Column must be defined for updating.', 5044002, 'sqlservices.processes.updateTable.columnNotDefined');
            $value = $datum['value'] ?? throw new SqlServicesException('Value must be defined for updating.', 5044003, 'sqlservices.processes.updateTable.valueNotDefined');
            // Create binding name, and bind the value.
            $bindingName = ':' . $column . '_' . $this->getBindingIndex();
            $this->addBinding($bindingName, $value);
            // Use the bind name in the query.
            $updateQuery .= "`" . $column . "` = " . $bindingName . ", ";
        }

        // Remove the last comma and space.
        $updateQuery = substr($updateQuery, 0, -2);

        // Add the where clause.
        if (isset($actionLog['where'])) {
            $updateQuery .= $this->where($actionLog['where']);
        }

        // Add the limit clause.
        if (isset($actionLog['limit'])) {
            $updateQuery .= $this->limit($actionLog['limit']);
        }

        // Return the query.
        $this->queryLog['query'] = $updateQuery;
        return $this->queryLog;
    }

}