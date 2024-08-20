<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\CreateTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\AlterTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\RenameTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\TruncateTable;
use NGFramer\NGFramerPHPSQLServices\Actions\DataDefinition\DropTable;

final class TableActions
{
    /**
     * Only variable made to use in all other functions.
     * @var string
     */
    private string $table;


    /**
     * Constructor, takes in one value and makes it accessible to the entire class.
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        return $this;
    }


    /**
     * This function returns an instance of the class CreateTable, with functions to create table.
     * @return CreateTable
     * @throws SqlServicesException
     */


    public function create(): CreateTable
    {
        return new CreateTable($this->table);
    }


    /**
     * This function returns an instance of the class with functions to alter the table.
     * @return AlterTable
     * @throws SqlServicesException
     */
    public function alter(): AlterTable
    {
        return new AlterTable($this->table);
    }


    /**
     * This function returns an instance of the class with functions to rename the table.
     * @return RenameTable
     * @throws SqlServicesException
     */
    public function rename(): RenameTable
    {
        return new RenameTable($this->table);
    }


    /**
     * This function returns an instance of the class with functions to truncate the table.
     * @return TruncateTable
     * @throws SqlServicesException
     */
    public function truncate(): TruncateTable
    {
        return new TruncateTable($this->table);
    }


    /**
     * This function returns an instance of the class with functions to drop the table.
     * @return DropTable
     * @throws SqlServicesException
     */
    public function drop(): DropTable
    {
        return new DropTable($this->table);
    }
}