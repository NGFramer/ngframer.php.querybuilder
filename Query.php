<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

require 'vendor/autoload.php';

Class Query
{
    // Function to get and set the tableName and viewName;
    public function table(string $tableName): Table
    {
        return new Table($tableName);
    }

    public function view(string $viewName): View
    {
        return new View($viewName);
    }
}