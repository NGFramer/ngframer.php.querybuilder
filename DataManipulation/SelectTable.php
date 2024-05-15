<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class SelectTable extends _DmlTable
{
    // Use the following trait to access the functions.
    use whereTrait, limitTrait, sortByTrait, groupByTrait{
        whereTrait::build as buildWhere; // TODO: To be built.
        limitTrait::build as buildLimit; // TODO: To be built.
        sortByTrait::build as buildSortBy; // TODO: To be built.
        groupByTrait::build as buildGroupBy; // TODO: To be built.
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
                throw new \InvalidArgumentException('Field names must be string.');
            }
            $this->addToQueryLogDeepArray('columns', $field);
        }
    }




    // Builder function for the class.
    public function build(): string
    {
        return "";
    }
}