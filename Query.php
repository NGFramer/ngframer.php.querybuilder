<?php

namespace NGFramer\NGFramerPHPSQLServices;

use NGFramer\NGFramerPHPSQLServices\TransactionControl\StartStop;

Class Query
{
    // Use the following trait.
    use StartStop;


    // Function to get and set the tableName.
    public static function table(string $tableName): Table
    {
        return new Table($tableName);
    }


    // Function to get and set the viewName.
    public static function view(string $viewName): View
    {
        return new View($viewName);
    }
}
