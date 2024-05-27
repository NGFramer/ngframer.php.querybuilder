<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class DeleteTable extends _DmlTable
{
    // Use the following trait to access the functions.
    use WhereTrait{
        WhereTrait::buildQuery as buildWhere;
    }


    // Constructor function for the class.
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
        $this->addQueryLog('table', $tableName, 'deleteData');
    }


    // Go direct function for where conditions.
    public function goDirect(): self
    {
        // Get the goDirect function from parent.
        parent::goDirect();
        // Return instance for object chaining.
        return $this;
    }

    
    // Main builder function for the class.
    public function buildQuery(): string
    {
        // Get the table name from the query log.
        $tableName = $this->getQueryLog()['table'];
        // Initialize the delete query with table name.
        $query = "DELETE FROM {$tableName}";
        // Get the where condition clause. And, merge with query.
        $whereClause = $this->buildWhere();
        if (!empty($whereClause)) {
            $query .= "{$whereClause}";
        }
        // Return the query.
        return $query;
    }
}