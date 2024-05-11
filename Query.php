<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

require 'vendor/autoload.php';

Class Query
{
    // Variable defined here.
    private bool $goDirect = false;
    private array $bindParameters = [];




    // Function to get and set the tableName and viewName;
    public function table(string $tableName): Table
    {
        return new Table($tableName);
    }

    public function view(string $viewName): View
    {
        return new View($viewName);
    }




    // More utilities functions for the class.
    public function accessBindParametersIndex(): int
    {
        // Returns the number of binding parameters that have been stored.
        return count($this->bindParameters);
    }

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