<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPException\exception\SqlBuilderException;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class SelectTable extends _DmlTable
{
    // Use the following trait to access the functions.
    use WhereTrait, LimitTrait, SortByTrait, GroupByTrait {
        WhereTrait::buildQuery as buildWhere;
        SortByTrait::buildQuery as buildSortBy;
        GroupByTrait::buildQuery as buildGroupBy;
        LimitTrait::buildQuery as buildLimit;
    }


    // Constructor function for the class.
    public function __construct(string $tableName, array $columns)
    {
        parent::__construct($tableName);
        $this->addQueryLog('table', $tableName, 'selectData');
        $this->select($columns);
    }


    // Main function for the class.
    public function select(array $fields): void
    {
        foreach ($fields as $field) {
            if (!is_string($field)) {
                throw new SqlBuilderException('InvalidArgumentException, Field names must be string.', 500, ['dmlSelect_invalid_data', 0x24]);
            }
            $this->addToQueryLogDeepArray('columns', $field);
        }
    }


    // Go direct function for where conditions.
    public function goDirect(): self
    {
        // Get the goDirect function from parent.
        parent::goDirect();
        // Return instance for object chaining.
        return $this;
    }


    // Builder function for the class.
    public function buildQuery(): string
    {
        // Get the queryLog initially to process.
        $queryLog = $this->getQueryLog();
        // Start building the where query.
        $query = 'SELECT ';
        $query .= implode(', ', $queryLog['columns']);
        $query .= ' FROM ' . $queryLog['table'];
        $query .= $this->buildWhere();
        $query .= $this->buildGroupBy();
        $query .= $this->buildSortBy();
        $query .= $this->buildLimit();
        return $query;
    }
}