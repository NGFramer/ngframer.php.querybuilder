<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class SelectTable extends _DmlTable
{
    // Constructor function for the class.
    public function __construct(string $tableName, array $columns)
    {
        parent::__construct($tableName);
        $this->addQueryLog('table', $tableName, 'selectData');
        $this->select($columns);
    }




    // Main function for the class.
    public function select(array $fields)
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