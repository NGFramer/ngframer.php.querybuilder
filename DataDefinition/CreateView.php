<?php

namespace NGFramer\NGFramerPHPSQLBuilder\DataDefinition;

class CreateView
{
    public static function create(string $viewName): string
    {
        return "CREATE VIEW " . $viewName . " AS ";
    }
}