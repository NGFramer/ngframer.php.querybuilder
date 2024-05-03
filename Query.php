<?php

namespace NGFramer\NGFramerPHPSQLBuilder;

use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Delete;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Insert;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Select;
use NGFramer\NGFramerPHPSQLBuilder\DataManipulation\Update;

Class Query
{
    // Variable defined here.
    private static ?string $tableName = null;
    private bool $goDirect = false;
    private array $bindParameters = [];



    // Function to get and set the tableName;
    public static function table(string $tableName): self
    {
        $table = new Table();
        $table->setTableName($tableName);
        self::$tableName = $table->getTableName();
        return new Query;
    }


    // Data manipulation functions.
    public function select(string ...$fields): void
    {
        $tableName = self::$tableName;
        Select::build($tableName, $fields);
    }


    public function insert(array $data): void
    {
        $tableName = $this->tableName;
        $goDirect = $this->goDirect;
        $bindIndexStarter = $this->accessBindParametersIndex();
        Insert::build($tableName, $data, $goDirect, $bindIndexStarter);
    }


    public function update(array $data): void
    {
        $tableName = $this->tableName;
        $goDirect = $this->goDirect;
        $bindIndexStarter = $this->accessBindParametersIndex();
        Update::build($tableName, $data, $goDirect, $bindIndexStarter);
    }


    public function delete(): void
    {
        $tableName = $this->tableName;
        Delete::build($tableName);
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