<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataManipulation;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Supportive\_DmlTable;

class DeleteTable extends _DmlTable
{
    // Use the following trait to access the functions.
    use WhereTrait;




    // Constructor function for the class.
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
        $this->addQueryLog('table', $tableName, 'deleteData');
    }




    // Main builder function for the class.
    public function build(): string
    {
        return "";
    }
}