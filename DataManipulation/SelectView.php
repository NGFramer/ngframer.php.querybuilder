<?php

namespace NGFramer\NGFramerPHPSQLServices\DataManipulation;

use NGFramer\NGFramerPHPExceptions\exceptions\SqlBuilderException;
use NGFramer\NGFramerPHPSQLServices\DataManipulation\Supportive\_DmlView;

class SelectView extends _DmlView
{
    // Use the following trait to access the functions.
    use WhereTrait, LimitTrait, SortByTrait, GroupByTrait {
        WhereTrait::buildQuery as buildWhere;
        SortByTrait::buildQuery as buildSortBy;
        GroupByTrait::buildQuery as buildGroupBy;
        LimitTrait::buildQuery as buildLimit;
    }


    // Constructor function for the class.
    public function __construct(string $viewName, array $columns)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'selectData');
        $this->select($columns);
    }


    // Set the action for the table.
    protected function setAction(): void
    {
        parent::setAction("selectData");
    }


    // Main function for the class.
    public function select(array $fields): void
    {
        foreach ($fields as $field) {
            if (!is_string($field)) {
                throw new SqlBuilderException('InvalidArgumentException, Field names must be string.', 0, null, 500, ['dmlSelect_invalid_data', 0x25]);
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
        $query .= ' FROM ' . $queryLog['view'];
        $query .= $this->buildWhere();
        $query .= $this->buildSortBy();
        $query .= $this->buildGroupBy();
        $query .= $this->buildLimit();
        return $query;
    }
}