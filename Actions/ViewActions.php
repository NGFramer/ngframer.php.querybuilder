<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\AlterView;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\CreateView;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\DropView;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\RenameView;
use NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation\SelectView;

final class ViewActions
{
    /**
     * Only variable made to use in all other functions.
     * @var string
     */
    private string $view;


    /**
     * Constructor, takes in one value and makes it accessible to the entire class.
     * @param string $viewName
     */
    public function __construct(string $viewName)
    {
        $this->view = $viewName;
    }


    /**
     * This function returns an instance of the class CreateView, with functions to create view.
     * @return CreateView
     * @throws Exception
     */
    public function create(): CreateView
    {
        return new CreateView($this->view);
    }


    /**
     * This function returns an instance of the class AlterView, with functions to alter view.
     * @throws Exception
     * @return AlterView
     */
    public function alter(): AlterView
    {
        return new AlterView($this->view);
    }


    /**
     * This function returns an instance of the class DropView, with functions to drop view.
     * @throws Exception
     * @return DropView
     */
    public function drop(): DropView
    {
        return new DropView($this->view);
    }


    /**
     * This function returns an instance of the class SelectView, with functions to select view.
     * @param string ...$fields
     * @return SelectView
     * @throws Exception
     */
    public function select(string ...$fields): SelectView
    {
        return new SelectView($this->view, $fields);
    }
}