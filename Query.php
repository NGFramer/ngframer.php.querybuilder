<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

Class Query
{
    // Variable defined here.
    private string $tableName = null;
    private bool $goDirect = false;
    private array $bindParameters = [];

    // Function to get and set the tableName;
    public function table(string $tableName): void
    {
        \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Table::setTableName($tableName);
        $this->tableName = \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Table::getTableName();
    }

    public function select(string ...$fields)
    {
        $tableName = $this->tableName;
        \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Select::build($tableName, $fields);
    }

    public function insert(array $data)
    {
        $tableName = $this->tableName;
        $goDirect = $this->goDirect;
        $bindIndexStarter = $this->getBindIndexStarter();
        \NGFramer\NGFramerPHPSQLBuilder\datamanipulation\Insert::build($tableName, $data, $goDirect, $bindIndexStarter);
    }

    // More utilities functions for the class.
    public function accessBindParametersIndex(): int
    {
        // Returns the number of binding parameters that have been stored.
        return count($this->bindParameters);
    }

    public function updateBindParameters(string $key, string $value){
        if (array_key_exists($key, $this->bindParameters)){
            throw new \Exception("Something unexpected happened. Repeated bindParameters Key.");
        }else{
            $this->bindParameters[$key] = $value;
        }
    }

    public function goDirect()
    {
        // Use this function to set the method of executing the query to direct (not using prepare).
        $this->goDirect = true;
    }

    public function getBindIndexStarter(){
        return $this->goDirect() ? count($this->bindParameters):0;
    }        
}