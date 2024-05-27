<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\AlterView;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\CreateView;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\DropView;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\RenameView;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\SelectView;

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