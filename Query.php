<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Alter;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Create;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\CreateView;
use NGFramer\NGFramerPHPSQLBuilder\DataDefinition\Truncate;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Delete;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Insert;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Select;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Update;

Class Query
{
    // Variable defined here.
    private bool $goDirect = false;
    private array $bindParameters = [];
    private string $lastSetAction;
    private Table $table;
    private View $view;




    // Constructor for the config.
    public function __construct()
    {
        require_once "config.php";
    }




    // Setting last action for check points.
    private function setLastAction(string $action): void
    {
        $this->lastSetAction = $action;
    }

    private function getLastAction(): string
    {
        return $this->lastSetAction;
    }




    // Function to get and set the tableName and viewName;
    public function table(string $tableName): self
    {
        $this->table = new Table();
        $this->table->setTableName($tableName);
        $this->setLastAction('setTable');
        return $this;
    }

    public function view(string $viewName): self
    {
        $this->view = new View();
        $this->view->setViewName($viewName);
        $this->setLastAction('setView');
        return $this;
    }




    // Data Definition functions.
    public function create(): void
    {
        $create = new Create();
        $create->create($this->getLastAction());
    }

    public function alter(): void
    {
        $alter = new Alter();
        $alter->alter($this->getLastAction());
    }

    public function modify(): void
    {
        $this->alter();
    }




    // Data manipulation functions.
    // TODO: All the manipulation function need to be maintained.
    public function select(string ...$fields): void
    {
        Select::build(self::$tableName, $fields);
    }

    public function insert(array $data): void
    {
        $bindIndexStarter = $this->accessBindParametersIndex();
        Insert::build(self::$tableName, $data, $this->goDirect, $bindIndexStarter);
    }

    public function update(array $data): void
    {
        $bindIndexStarter = $this->accessBindParametersIndex();
        Update::build(self::$tableName, $data, $this->goDirect, $bindIndexStarter);
    }


    public function delete(): void
    {
        Delete::build(self::$tableName);
    }




    // Data Definition Functions.
    public function Drop(): void
    {
        (new DataDefinition\Drop)->build(self::$tableName);
    }

    public function Truncate(): void
    {
        Truncate::build(self::$tableName);
    }





    // More utilities functions for the class.
    public function accessBindParametersIndex(): int
    {
        // Returns the number of binding parameters that have been stored.
        return count($this->bindParameters);
    }

    /**
     * @throws \Exception
     */
    public function updateBindParameters(string $key, string $value): void
    {
        if (array_key_exists($key, $this->bindParameters)){
            throw new \Exception("Something unexpected happened. Repeated bindParameters Key.");
        }else{
            $this->bindParameters[$key] = $value;
        }
    }

    public function goDirect(): void
    {
        // Use this function to set the method of executing the query to direct (not using prepare).
        $this->goDirect = true;
    }

    public function getBindIndexStarter(): int
    {
        return $this->goDirect ? count($this->bindParameters):0;
    }        
}