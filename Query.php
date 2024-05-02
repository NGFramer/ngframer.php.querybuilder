<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

use NGFramer\NGFramerPHPSQLBuilder\datadefinition\Truncate;

Class Query
{
    // Variable defined here.
    private ?string $tableName = null;
    private bool $goDirect = false;
    private array $bindParameters = [];


    // Function to get and set the tableName;
    public function table(string $tableName): void
    {
        Table::setTableName($tableName);
        $this->tableName = Table::getTableName();
    }


    // Data manipulation functions.
    public function select(string ...$fields)
    {
        $tableName = $this->tableName;
        DataManipulation::select($tableName, $fields);
    }

    public function insert(array $data)
    {
        $tableName = $this->tableName;
        $goDirect = $this->goDirect;
        $bindIndexStarter = $this->accessBindParametersIndex();
        DataManipulation::insert($tableName, $data, $goDirect, $bindIndexStarter);
    }

    public function update(array $data)
    {
        $tableName = $this->tableName;
        $goDirect = $this->goDirect;
        $bindIndexStarter = $this->accessBindParametersIndex();
        DataManipulation::update($tableName, $data, $goDirect, $bindIndexStarter);
    }

    public function delete()
    {
        $tableName = $this->tableName;
        DataManipulation::delete($tableName);
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