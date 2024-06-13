<?php

namespace NGFramer\NGFramerPHPSQLServices;

use NGFramer\NGFramerPHPSQLServices\DataDefinition\AlterView;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\CreateView;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\DropView;
use NGFramer\NGFramerPHPSQLServices\DataDefinition\RenameView;
use NGFramer\NGFramerPHPSQLServices\DataManipulation\SelectView;

class View
{
    private string $viewName;

    
    public function __construct(string $viewName)
    {
        $this->viewName = $viewName;
    }


    public function create(): CreateView
    {
        return new CreateView($this->viewName);
    }


    public function alter(): AlterView
    {
        return new AlterView($this->viewName);
    }


    public function rename($newViewName): RenameView
    {
        return new RenameView($this->viewName, $newViewName);
    }


    public function drop(): DropView
    {
        return new DropView($this->viewName);
    }


    public function select(string ...$fields): SelectView
    {
        return new SelectView($this->viewName, $fields);
    }

}