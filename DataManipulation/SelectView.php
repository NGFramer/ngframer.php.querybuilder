<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlView;

class SelectView extends _DmlView
{
    // Use the following trait to access the functions.
    use WhereTrait, limitTrait, sortByTrait, groupByTrait{
        WhereTrait::build as buildWhere;
//        limitTrait::build as buildLimit; // TODO: To be built.
//        sortByTrait::build as buildSortBy; // TODO: To be built.
//        groupByTrait::build as buildGroupBy; // TODO: To be built.
    }




    // Constructor function for the class.
    public function __construct(string $viewName, array $columns)
    {
        parent::__construct($viewName);
        $this->addQueryLog('view', $viewName, 'selectData');
        $this->select($columns);
    }




    // Main function for the class.
    public function select(array $fields): void
    {
        foreach ($fields as $field) {
            if (!is_string($field)) {
                throw new \InvalidArgumentException('Field names must be string.');
            }
            $this->addToQueryLogDeepArray('columns', $field);
        }
    }




    // Builder function for the class.
    public function build(): string
    {
        // Get the queryLog initially to process.
        $queryLog = $this->getQueryLog();
        // Start building the where query.
        $query = 'SELECT ';
        $query .= implode(', ', $queryLog['columns']);
        $query .= ' FROM ' . $queryLog['view'];
        $query .= $this->buildWhere();
//        $query .= $this->buildSortBy();
//        $query .= $this->buildGroupBy();
//        $query .= $this->buildLimit();
        return $query;
    }
}