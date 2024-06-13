<?php

namespace NGFramer\NGFramerPHPSQLServices;

Class Query
{
    // Function to get and set the tableName and viewName;
    public static function table(string $tableName): Table
    {
        return new Table($tableName);
    }

    public static function view(string $viewName): View
    {
        return new View($viewName);
    }
}
