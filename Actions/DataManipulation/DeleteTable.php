<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

final class DeleteTable extends StructureTable
{
    /**
     * Use the following traits in this class.
     */
    use LimitTrait;
    use OffsetTrait;
    use WhereTrait;


    /**
     * This sets the tableName and the action to the actionLog.
     * @param string $table
     * @throws SqlServicesException
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('deleteTable');
        return $this;
    }
}