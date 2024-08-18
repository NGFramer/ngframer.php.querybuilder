<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use Exception;

Trait GroupByTrait
{
    /**
     * This function adds groupBy details to the actionLog.
     * @param string $columnName
     * @return GroupByTrait|SelectTable|SelectView
     * @throws Exception
     */
    public function groupBy(string $columnName): self
    {
        $this->addToActionLog('groupBy', $columnName);
        return $this;
    }
}