<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use Exception;
use NGFramer\NGFramerPHPSQLServices\Actions\_Structure\StructureView;

final class SelectView extends StructureView
{
    /**
     * Use the following traits.
     */
    use SortByTrait;
    use LimitTrait;
    use GroupByTrait;
    use OffsetTrait;


    /**
     * This sets the tableName and the action to the actionLog.
     * @param string $table
     * @throws Exception
     */
    public function __construct(string $table)
    {
        parent::__construct($table);
        $this->setAction('selectView');
        return $this;
    }


    /**
     * This will add fields to the actionLog.
     * @param string ...$fields
     * @return SelectView
     * @throws Exception
     */
    public function select(string ...$fields): self
    {
        $this->addToActionLog('select', $fields);
        return $this;
    }

}