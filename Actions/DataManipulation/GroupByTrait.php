<?php

namespace NGFramer\NGFramerPHPSQLServices\Actions\DataManipulation;

use NGFramer\NGFramerPHPSQLServices\Exceptions\SqlServicesException;

Trait GroupByTrait
{
    /**
     * This function adds groupBy details to the actionLog.
     * @param string $columnName
     * @return GroupByTrait|SelectTable|SelectView
     * @throws SqlServicesException
     */
    public function groupBy(string $columnName): self
    {
        $this->addToActionLog('groupBy', $columnName);
        return $this;
    }
}