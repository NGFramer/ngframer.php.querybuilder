<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlView;

class SelectView extends _DmlView
{
    // Use the following trait to access the functions.
    use WhereTrait;




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
        return "";
    }
}