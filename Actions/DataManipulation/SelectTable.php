<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureTable;

final class SelectTable extends StructureTable
{
    /**
     * Use the following traits in this class.
     */
    use SortByTrait;
    use LimitTrait;
    use GroupByTrait;
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
        $this->setAction('selectTable');
        return $this;
    }


    /**
     * This will add fields to the actionLog.
     * @param string ...$fields
     * @return SelectTable
     * @throws SqlServicesException
     */
    public function select(string ...$fields): self
    {
        $this->addToActionLog('select', $fields);
        return $this;
    }
}